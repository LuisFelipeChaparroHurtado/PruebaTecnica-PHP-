<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron mt-5">
            <h1 class="display-5">PRUEBA TÉCNICA - DESARROLLADOR DE SOFTWARE</h1>
            <p class="lead text-justify">
                La empresa Comboplay SAS, necesita de un software de inventario que les permita
                gestionar la asignación de los activos de la empresa (portátiles, móviles, monitores,
                teclados, entre otros) a los colaboradores de esta. De esta manera, el software debe
                permitir la creación, edición y eliminación de activos y colaboradores de la empresa,
                así como también, debe permitir listar todos los registros de cada uno de ellos.
                Adicionalmente, se debe contar con un módulo que permita realizar la asignación
                de los activos a un colaborador de la empresa, el cual recibirá como parámetros el
                ID y Serial del activo a asignar, junto con el ID del colaborador de la empresa a quien
                se le asigna. Así mismo, debe quedar el registro de la asignación en una entidad de
                logs, donde se tengan como mínimo los datos del activo asignado, los datos básicos
                del colaborador y el usuario que realizó la asignación.
            </p>
            <hr class="my-4">
        </div>

        <div class="container">
            <h2>Reportes del inventario</h2>

            <div class="row">
                <div class="col-md-6">
                    <h3>Activos asignados por empleado</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-primary bg-primary text-white">
                            <tr>
                                <th>Empleado</th>
                                <th>Activos Asignados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activosPorEmpleado as $item)
                                <tr>
                                    <td>{{ $item->Empleado }}</td>
                                    <td>{{ $item->ActivosAsignados }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3>Departamento con menos activos asignados</h3>
                    @if (!empty($departamentoConMenosActivos))
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-primary bg-primary text-white">
                                <tr>
                                    <th>Departamento</th>
                                    <th>Activos Asignados</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departamentoConMenosActivos as $item)
                                    <tr>
                                        <td>{{ $item->Departamento }}</td>
                                        <td>{{ $item->ActivosAsignados }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay datos disponibles.</p>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Estado general del inventario</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-primary bg-primary text-white">
                            <tr>
                                <th>Total de Activos</th>
                                <th>Activos Asignados</th>
                                <th>Activos Disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $estadoGeneralInventario->TotalActivos }}</td>
                                <td>{{ $estadoGeneralInventario->ActivosAsignados }}</td>
                                <td>{{ $estadoGeneralInventario->ActivosDisponibles }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
