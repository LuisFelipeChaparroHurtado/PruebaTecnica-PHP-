@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center p-3">Asignar Activos</h1>

        @if (session('correcto'))
            <div class="alert alert-success">{{ session('correcto') }}</div>
        @endif

        @if (session('incorrecto'))
            <div class="alert alert-danger">{{ session('incorrecto') }}</div>
        @endif


        <script>
            var res = function() {
                var not = confirm("¿Estas seguro de eliminar?")
                return not;
            }

            // Function to filter table based on input
            function filterTable() {
                const input = document.getElementById("searchInput");
                const filter = input.value.toUpperCase();
                const table = document.getElementById("dataTable");
                const tr = table.getElementsByTagName("tr");

                for (let i = 1; i < tr.length; i++) {
                    const tdColaborador = tr[i].getElementsByTagName("td")[0];
                    const tdActivo = tr[i].getElementsByTagName("td")[1];
                    if (tdColaborador || tdActivo) {
                        const txtValueColaborador = tdColaborador.textContent || tdColaborador.innerText;
                        const txtValueMarca = tdActivo.textContent || tdActivo.innerText;
                        if (txtValueColaborador.toUpperCase().indexOf(filter) > -1 || txtValueMarca.toUpperCase().indexOf(
                                filter) > -
                            1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar activos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('assign.create') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">ID del Colaborador</label>
                                <select class="form-control" id="exampleInputEmail1" name="txtcolaborador">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_id" class="form-label">ID del Activo</label>
                                <select class="form-control" id="exampleInputEmail1" name="txtactivo">
                                    <option value=""></option>
                                    @foreach ($activos as $activo)
                                        <option value="{{ $activo->id }}">{{ $activo->serial_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="serial_code" class="form-label">Asignado por</label>
                                <input type="text" class="form-control" id="serial_code" name="txtasignado" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Asignar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <table class="table table-striped table-bordered table-hover" id="dataTable">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalRegistrar">Añadir
                    activo</button>
                <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control me-2"
                    placeholder="Buscar por marca o número de serie" style="width: 300px;">
            </div>


            <thead class="table-primary bg-primary text-white">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">COLABORADOR</th>
                    <th scope="col">ACTIVO DE LA COMPAÑIA</th>
                    <th scope="col">ASSIGNER</th>
                    <th scope="col">CREADO EN</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($datos as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->employee_name }}</td>
                        <td>{{ $item->asset_serial_code }}</td>
                        <td>{{ $item->assigner }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td class="text-center">
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $item->id }}"
                                class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('assign.delete', $item->id) }}" onclick="return res()"
                                class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>


                    <div class="modal fade" id="modalEditar{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos de asignación de activos</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('assign.update') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Id</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtid"
                                                    value="{{ $item->id }}" readonly>
                                            </div>
                                        <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Colaborador</label>
                                                <select class="form-control" id="exampleInputEmail1"
                                                    name="txtcolaborador">
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            @if ($employee->id == $item->id) selected @endif>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <div class="mb-3">
                                            <label for="asset_id" class="form-label">ID del Activo</label>
                                            <select class="form-control" id="exampleInputEmail1" name="txtactivo">
                                                @foreach ($activos as $activo)
                                                    <option value="{{ $activo->id }}"
                                                        @if ($activo->id == $item->id) selected @endif>
                                                        {{ $activo->serial_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="serial_code" class="form-label">Asignado por</label>
                                            <input type="text" class="form-control" id="serial_code"
                                                name="txtasignado" value="{{ $item->assigner }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Asignar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
