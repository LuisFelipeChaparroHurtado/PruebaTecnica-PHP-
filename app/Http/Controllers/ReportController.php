<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Consulta 1: Cuántos activos tiene asignado cada empleado
        $activosPorEmpleado = DB::select("
            SELECT employees.name AS Empleado, COUNT(company_assets.id) AS ActivosAsignados
            FROM company_assets
            JOIN employees ON company_assets.employees_id = employees.id
            GROUP BY employees.name
        ");

        // Consulta 2: Cuál departamento de la empresa tiene menos activos asignados
        $departamentoConMenosActivos = DB::select("
            SELECT employees.department AS Departamento, COUNT(company_assets.id) AS ActivosAsignados
            FROM company_assets
            JOIN employees ON company_assets.employees_id = employees.id
            GROUP BY employees.department
            ORDER BY ActivosAsignados ASC
            LIMIT 1
        ");

        // Consulta 3: Generación de reportes del estado general del inventario
        $estadoGeneralInventario = DB::select("
            SELECT 
                (SELECT COUNT(*) FROM company_assets) AS TotalActivos,
                (SELECT COUNT(*) FROM company_assets WHERE employees_id IS NOT NULL) AS ActivosAsignados,
                (SELECT COUNT(*) FROM company_assets WHERE employees_id IS NULL) AS ActivosDisponibles
        ");

        return view('welcome', [
            'activosPorEmpleado' => $activosPorEmpleado,
            'departamentoConMenosActivos' => $departamentoConMenosActivos,
            'estadoGeneralInventario' => $estadoGeneralInventario[0]
        ]);
    }
}