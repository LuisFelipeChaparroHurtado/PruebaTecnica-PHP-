<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetsController extends Controller
{
    public function index()
    {
        $datos = DB::select("select * from company_assets");
        $employees = DB::select("select id, name from employees");
        return view("companyAssets.index", ['datos' => $datos, 'employees' => $employees]);
    }


    public function create(Request $request)
    {
        try {
            // Validar la solicitud
            $validatedData = $request->validate([
                'txtserial' => 'required|max:250',
                'txtmarca' => 'required|max:45',
                'txtreferencia' => 'required|max:250',
                'txtdescipcion' => 'required|max:250',
                'txtcolaborador' => 'nullable|exists:employees,id'
            ]);

            // Insertar datos en la base de datos
            $sql = DB::insert(
                "INSERT INTO company_assets (serial_code, trademark, reference, description, employees_id) VALUES (?, ?, ?, ?, ?)",
                [
                    $request->txtserial,
                    $request->txtmarca,
                    $request->txtreferencia,
                    $request->txtdescipcion,
                    $request->txtcolaborador
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
                'txtserial' => 'required|max:250',
                'txtmarca' => 'required|max:45',
                'txtreferencia' => 'required|max:250',
                'txtdescipcion' => 'required|max:250',
                'txtcolaborador' => 'required|integer'
            ]);

            // Actualizar datos en la base de datos
            $sql = DB::update(
                "UPDATE company_assets SET serial_code=?, trademark=?, reference=?, description=?, employees_id=? WHERE id=?",
                [
                    $request->txtserial,
                    $request->txtmarca,
                    $request->txtreferencia,
                    $request->txtdescipcion,
                    $request->txtcolaborador,
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
            $sql = DB::delete("delete from company_assets where id =$txtid");
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
