@extends('layouts.app')
@section('content')
    <div>
        <h1 class="text-center p-3">CRUD ACTIVOS</h1>

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
                    const tdSerial = tr[i].getElementsByTagName("td")[0];
                    const tdMarca = tr[i].getElementsByTagName("td")[1];
                    if (tdSerial || tdMarca) {
                        const txtValueSerial = tdSerial.textContent || tdSerial.innerText;
                        const txtValueMarca = tdMarca.textContent || tdMarca.innerText;
                        if (txtValueSerial.toUpperCase().indexOf(filter) > -1 || txtValueMarca.toUpperCase().indexOf(filter) > -
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de activos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('companyAssets.create') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Códgo serial</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtserial">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Marca comercial</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtmarca">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Referencia</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtreferencia">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtdescipcion">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Colaborador</label>
                                <select class="form-control" id="exampleInputEmail1" name="txtcolaborador">
                                    <option value=""></option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
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
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalRegistrar">Añadir activo</button>
                <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control me-2" placeholder="Buscar por marca o número de serie" style="width: 300px;">
            </div>

            <table class="table table-striped table-bordered table-hover" id="dataTable">
                <thead class="table-primary bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">N° SERIAL</th>
                        <th scope="col">MARCA COMERCIAL</th>
                        <th scope="col">REFERENCIA</th>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">CREADO EN</th>
                        <th scope="col">ACTUALIZADO EN</th>
                        <th scope="col">COLABORADOR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($datos as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->serial_code }}</td>
                            <td>{{ $item->trademark }}</td>
                            <td>{{ $item->reference }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>{{ $item->employees_id }}</td>
                            <td class="text-center">
                                <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $item->id }}"
                                    class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('companyAssets.delete', $item->id) }}" onclick="return res()"
                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <!-- Modal modificar datos -->
                        <div class="modal fade" id="modalEditar{{ $item->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos del
                                            producto</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('companyAssets.update') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Id</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtid"
                                                    value="{{ $item->id }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Códgo serial</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtserial"
                                                    value="{{ $item->serial_code }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Marca comercial</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtmarca"
                                                    value="{{ $item->trademark }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Referencia</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtreferencia"
                                                    value="{{ $item->reference }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Descripción</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtdescipcion"
                                                    value="{{ $item->description }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Colaborador</label>
                                                <select class="form-control" id="exampleInputEmail1"
                                                    name="txtcolaborador">
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            @if ($employee->id == $item->employees_id) selected @endif>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
