@extends('layouts.app')
@section('personal-js')
    <script type="text/javascript" src="{{ asset('/js/employees/validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/employees.js') }}"></script>
@endsection
@section('content')

    <div class="col-12">
        <h4>Empleados</h4>
        <br>
        @if(session('success'))
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-success alert-dismissible fade show">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ session('success') }}</strong>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div>
            <div class="col-md-8 col-md-pull-9">
                <a id="btnExportEmployee" name="btnExportEmployee" href="{{ route('export_employee') }}" class="btn btn-dark">Exportar Datos</a>
            </div>
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#myModalEmployee">Ingresar Nuevo Empleado</button>
            </div>
        </div>
        <br>
        <form action="{{ Route('employees') }}" method="GET" id="form">
        <div class="input-group mb-3">
            <input type="text" class="form-control mr-2" placeholder="Buscar por: Clave, Nss, Nombre, Apellido Paterno" id="search" name="search">
            <div class="input-group-prepend">
                <span><button type="submit" class="btn btn-primary">Buscar</button></span>
            </div>
        </div>
        </form>
        <!-- INICIA MODAL PARA EXCEL -->
        <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h4 class="modal-title">Importar datos</h4>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <form method="POST" enctype="multipart/form-data" action="{{ Route('employee_file_upload') }}" role="form">
                            {{ csrf_field() }}
                            <label for="employee">Seleccionar archivo excel</label>
                            <input class="form-control btn" type="file" id="employee" name="employee" multiple>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- TERMINA MODAL -->
        <!-- Modal para guardar empleado Manual -->
        @include('layouts.employee.add_employee')
        <br>
            <div class="table-responsive-md">
                <table class="table table-hover table-borderless" id="#tableData">
                    <thead>
                    <tr class="table-primary">
                        <th>Clave</th>
                        <th>NSS</th>
                        <th>Sucursal</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Turno</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php($a = 0)
                    @foreach($employees as $employee)
                        @php($a = $employee->id)
                        <tr>
                            <td>{{ $employee->clave }}</td>
                            <td>{{ $employee->nss }}</td>
                            <td>{{ $employee->sucursal }}</td>
                            <td>{{ $employee->nombre }}</td>
                            <td>{{ $employee->apellido_paterno }}</td>
                            <td>{{ $employee->apellido_materno }}</td>
                            <td>{{ $employee->turno }}</td>
                            <td>
                                @csrf
                                @method('DELETE')
                                <!-- Modal para editar empleado Manual -->
                                @include('layouts.employee.edit_employee')
                                <a data-toggle="modal" data-target="#myModalEmployeeEdit{{ $a }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                                <!-- Modal para eliminar empleado Manual -->
                                @include('layouts.employee.delete_employee')
                                <a data-toggle="modal" data-target="#myModalEmployeeDelete{{ $a }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        {{ $employees->links() }}
        </div>

@endsection
