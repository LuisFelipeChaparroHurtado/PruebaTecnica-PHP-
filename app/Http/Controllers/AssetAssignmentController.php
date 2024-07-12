<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetAssignmentController extends Controller
{

    public function index()
    {
        $datos = DB::select('
        SELECT logs.id as id, employees.name AS employee_name, company_assets.serial_code AS asset_serial_code,
               logs.assigner, logs.created_at
        FROM logs
        JOIN employees ON logs.employees_id = employees.id
        JOIN company_assets ON logs.company_assets_id = company_assets.id
    ');
        $employees = DB::select("select id, name from employees");
        $activos = DB::select("select id, serial_code from company_assets");
        return view("assign.assign", ['datos' => $datos, 'employees' => $employees, 'activos' => $activos]);
    }

    public function create(Request $request)
    {
        try {
            // Validar la solicitud
            $validatedData = $request->validate([
                'txtcolaborador' => 'required|integer',
                'txtactivo' => 'required|integer',
                'txtasignado' =>  'required|max:250'
            ]);

            // Insertar datos en la base de datos
            $sql = DB::insert(
                "INSERT INTO logs (employees_id, company_assets_id, assigner) VALUES (?, ?, ?)",
                [
                    $request->txtcolaborador,
                    $request->txtactivo,
                    $request->txtasignado
                ]
            );

            if ($sql) {
                return back()->with('correcto', 'Activo registrado correctamente');
            } else {
                return back()->with('incorrecto', 'Error al registrar el activo');
            }
        } catch (\Throwable $th) {
            // Manejo de excepciones
            return back()->with('incorrecto', 'Error al registrar el activo: ' . $th->getMessage());
        }
    }

    public function update(Request $request)
    {

        try {
            // Validar la solicitud
            $validatedData = $request->validate([
                'txtid' => 'required|integer',
                'txtcolaborador' => 'required|integer',
                'txtactivo' => 'required|integer',
                'txtasignado' =>  'required|max:250'
            ]);

            // Actualizar datos en la base de datos
            $sql = DB::update(
                "UPDATE logs SET employees_id=?, company_assets_id=?, assigner=? WHERE id=?",
                [
                    $request->txtcolaborador,
                    $request->txtactivo,
                    $request->txtasignado,
                    $request->txtid
                ]
            );

            if ($sql == 0) {
                $sql = 1; // Si no se ha actualizado ninguna fila, lo consideramos como éxito para este caso
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == true) {
            return back()->with('correcto', 'Activo modificado correctamente');
        } else {
            return back()->with('incorrecto', 'Error al modificar el activo');
        }
    }

    public function delete($txtid)
    {
        try {
            $sql = DB::delete("delete from logs where id =$txtid");
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == true) {
            return back()->with("correcto", "Activo eliminado correctamente");
        } else {
            return back()->with("incorrecto", "Error al eliminar");
        }
    }
}
