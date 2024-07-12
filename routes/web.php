<?php

use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [ReportController::class, 'index'])->name('welcome');

/* ================================ EMPLEADOS ================================ */

// Ruta para listar todos los empleados
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// Ruta para añadir un nuevo empleado
Route::post('/employees/registrarEmpleado', [EmployeeController::class, 'create'])->name('employees.create');

// Ruta para modificar un empleado
Route::post('/employees/modificarEmpleado', [EmployeeController::class, 'update'])->name('employees.update');

// Ruta para eliminar un empleado
Route::get('/eliminarEmpleado-{id}', [EmployeeController::class, 'delete'])->name('employees.delete');


/* ================================ ACTIVOS ================================ */

// Ruta para listar todos los activos de la compañia
Route::get('/companyAssets', [AssetsController::class, 'index'])->name('companyAssets.index');

// Ruta para añadir un nuevo activo de la compañia
Route::post('/companyAssets/registrarEmpleado', [AssetsController::class, 'create'])->name('companyAssets.create');

// Ruta para modificar un activo de la compañia
Route::post('/companyAssets/modificarEmpleado', [AssetsController::class, 'update'])->name('companyAssets.update');

// Ruta para eliminar un activo de la compañia
Route::get('/companyAssets/eliminarEmpleado-{id}', [AssetsController::class, 'delete'])->name('companyAssets.delete');


// Ruta para listar todos los empleados
Route::get('/assign', [AssetAssignmentController::class, 'index'])->name('assign.assign');

// Ruta para añadir un nuevo activo de la compañia
Route::post('/assign/registrarActivos', [AssetAssignmentController::class, 'create'])->name('assign.create');

// Ruta para modificar un activo de la compañia
Route::post('/assign/modificarActivos', [AssetAssignmentController::class, 'update'])->name('assign.update');

// Ruta para eliminar un activo de la compañia
Route::get('/assign/eliminarActivos-{id}', [AssetAssignmentController::class, 'delete'])->name('assign.delete');