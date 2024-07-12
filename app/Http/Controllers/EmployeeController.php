<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index()
    {
        $datos = DB::select("select * from employees");
        return view("employees.index")->with("datos", $datos);
    }


    public function create(Request $request)
    {
        try {
            // Validar la solicitud
            $validatedData = $request->validate([
                'txtnombre' => 'required|max:250',
                'txttipodocumento' => 'required|max:45',
                'txtnumerodocumento' => 'required|integer',
                'txtposicion' => 'nullable|max:250',
                'txtdepartamento' => 'nullable|max:250',
            ]);

            // Insertar datos en la base de datos
            $sql = DB::insert(
                "INSERT INTO employees (name, document_type, document_number, position, department) VALUES (?, ?, ?, ?, ?)",
                [
                    $request->txtnombre,
                    $request->txttipodocumento,
                    $request->txtnumerodocumento,
                    $request->txtposicion,
                    $request->txtdepartamento
                ]
            );

            if ($sql) {
                return back()->with('correcto', 'Empleado registrado correctamente');
            } else {
                return back()->with('incorrecto', 'Error al registrar el empleado');
            }
        } catch (\Throwable $th) {
            // Manejo de excepciones
            return back()->with('incorrecto', 'Error al registrar el empleado: ' . $th->getMessage());
        }
    }

    public function update(Request $request)
    {

        try {
            // Validar la solicitud
            $validatedData = $request->validate([
                'txtid' => 'required|integer',
                'txtnombre' => 'required|max:250',
                'txttipodocumento' => 'required|max:45',
                'txtnumerodocumento' => 'required|integer',
                'txtposicion' => 'nullable|max:250',
                'txtdepartamento' => 'nullable|max:250',
            ]);

            // Actualizar datos en la base de datos
            $sql = DB::update(
                "UPDATE employees SET name=?, document_type=?, document_number=?, position=?, department=? WHERE id=?",
                [
                    $request->txtnombre,
                    $request->txttipodocumento,
                    $request->txtnumerodocumento,
                    $request->txtposicion,
                    $request->txtdepartamento,
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
            return back()->with('correcto', 'Empleado modificado correctamente');
        } else {
            return back()->with('incorrecto', 'Error al modificar el empleado');
        }
    }

    public function delete($txtid)
    {
        try {
            $sql = DB::delete("delete from employees where id =$txtid");
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == true) {
            return back()->with("correcto", "Producto eliminado correctamente");
        } else {
            return back()->with("incorrecto", "Error al eliminar");
        }
    }
}
