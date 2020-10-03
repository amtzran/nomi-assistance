@extends('layouts.app')

@section('content')

@section('personal-js')
<script type="text/javascript" src="{{ asset('/js/employees/validation.js') }}"></script>
@endsection

    <div class="col-12">
        <h4>Empleados</h4>
        <br>
        <div class="row">
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div>
            <div class="col-md-10 col-md-pull-9">
                <a id="btnExportEmployee" name="btnExportEmployee" href="{{ route('export_employee') }}" class="btn btn-dark">Exportar Datos</a>
            </div>
        </div>
        <!-- INICIA MODAL PARA INSCRIBIR -->
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
                            <label for="employee">Seleccionar archivo csv</label>
                            <input class="form-control btn" type="file" id="employee" name="employee" multiple>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- TERMINA MODAL PARA ELIMINAR REGISTRO -->

        <br>
            <div class="table-responsive-md">
                <table class="table table-hover border">
                    <thead>
                    <tr class="table-primary">
                        <th>Clave</th>
                        <th>NSS</th>
                        <th>Sucursal</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Turno</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->clave }}</td>
                            <td>{{ $employee->nss }}</td>
                            <td>{{ $employee->sucursal }}</td>
                            <td>{{ $employee->nombre }}</td>
                            <td>{{ $employee->apellido_paterno }}</td>
                            <td>{{ $employee->apellido_materno }}</td>
                            <td>{{ $employee->turno }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        {{ $employees->links() }}
        </div>

@endsection