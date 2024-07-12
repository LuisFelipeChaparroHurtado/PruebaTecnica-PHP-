@extends('layouts.app')
@section('content')
    <div>


        <h1 class="text-center p-3">CRUD EMPLEADOS</h1>

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
                    const tdNombre = tr[i].getElementsByTagName("td")[0];
                    const tdDocumento = tr[i].getElementsByTagName("td")[2];
                    if (tdNombre || tdDocumento) {
                        const txtValueNombre = tdNombre.textContent || tdNombre.innerText;
                        const txtValueDocumento = tdDocumento.textContent || tdDocumento.innerText;
                        if (txtValueNombre.toUpperCase().indexOf(filter) > -1 || txtValueDocumento.toUpperCase().indexOf(filter) > -
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de empleados</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('employees.create') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nombre del empleado</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtnombre">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tipo de documento</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txttipodocumento">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Número de documento</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtnumerodocumento">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Posición</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtposicion">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Departamento</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtdepartamento">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 table-responsive">
             <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalRegistrar">Añadir producto</button>
                <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control me-2" placeholder="Buscar por marca o número de serie" style="width: 300px;">
            </div>

            <table class="table table-striped table-bordered table-hover" id="dataTable">
                <thead class="table-primary bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">TIPO DOCUMENTO</th>
                        <th scope="col">N° DOCUMENTO</th>
                        <th scope="col">POSICIÓN</th>
                        <th scope="col">DEPARTAMENTO</th>
                        <th scope="col">CREADO EN</th>
                        <th scope="col">ACTUALIZADO EN</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($datos as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->document_type }}</td>
                            <td>{{ $item->document_number }}</td>
                            <td>{{ $item->position }}</td>
                            <td>{{ $item->department }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td class="text-center">
                                <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $item->id }}"
                                    class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('employees.delete', $item->id) }}" onclick="return res()"
                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>



                        <!-- Modal modificar datos -->
                        <div class="modal fade" id="modalEditar{{ $item->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos del colaborador</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('employees.update') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Id</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtid"
                                                    value="{{ $item->id }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Nombre del
                                                    empleado</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtnombre"
                                                    value="{{ $item->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Tipo de
                                                    documento</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txttipodocumento"
                                                    value="{{ $item->document_type }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Número de
                                                    documento</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtnumerodocumento"
                                                    value="{{ $item->document_number }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Posición</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtposicion"
                                                    value="{{ $item->position }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Departamento</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtdepartamento"
                                                    value="{{ $item->department }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Modificar</button>
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
