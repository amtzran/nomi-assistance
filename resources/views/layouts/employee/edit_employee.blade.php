 <!-- INICIA MODAL PARA EDITAR EMPLEADO MANUAL -->
 <div class="modal fade" id="myModalEmployeeEdit{{ $a }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title-employee">Editar Empleado</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                    <form action="{{ Route('updateEmployee') }}" method="POST" id="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="number" name="id" value="{{ $employee->id }}" hidden="hidden">
                            <label for="clave">Clave</label>
                            <input type="text" id="clave" class="form-control" name="clave" required="required" value="{{ $employee->clave }}" disabled="disabled">
                            <label for="nss">Nss</label>
                            <input type="text" id="nss" class="form-control" name="nss" required="required" value="{{ $employee->nss }}">
                            <label for="sucursal">Sucursal</label>
                            <select name="sucursal" id="sucursal" class="form-control">
                            <option value="{{ $employee->sucursalId }}" selected="true">{{ $employee->sucursal }}</option>
                                @foreach($sucursales as $sucursal)
                                  <option value="{{ $sucursal->clave }}">{{ $sucursal->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" class="form-control" name="nombre" required="required" value="{{ $employee->nombre }}">
                            <label for="apellido_paterno">Apellido Paterno</label>
                            <input type="text" id="apellido_paterno" class="form-control" name="apellido_paterno" required="required" value="{{ $employee->apellido_paterno }}">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" id="apellido_materno" class="form-control" name="apellido_materno" required="required" value="{{ $employee->apellido_materno }}">
                            <label for="turno">Turno</label>
                            <input type="text" id="turno" class="form-control" name="turno" required="required" value="{{ $employee->turno }}">
                             <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark" id="employeeEdit">Actualizar</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- TERMINA MODAL-->