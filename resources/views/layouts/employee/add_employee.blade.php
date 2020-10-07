<!-- INICIA MODAL PARA GUARDAR EMPLEADO MANUAL -->
<div class="modal fade" id="myModalEmployee" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title-employee">Nuevo Empleado</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" role="form">
                        {{ csrf_field() }}
                        <label for="clave">Clave</label>
                        <input type="text" id="clave" class="form-control" name="clave" required="required">
                        <label for="nss">Nss</label>
                        <input type="text" id="nss" class="form-control" name="nss" required="required">
                        <label for="sucursal">Sucursal</label>
                        <select name="sucursal" id="sucursal" class="form-control">
                            <option value="" disabled selected>Seleccione una Sucursal</option>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->clave }}">{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" required="required">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" id="apellido_paterno" class="form-control" name="apellido_paterno" required="required">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" id="apellido_materno" class="form-control" name="apellido_materno" required="required">
                        <label for="turno">Turno</label>
                        <input type="text" id="turno" class="form-control" name="turno" required="required">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="employeeNew">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- TERMINA MODAL-->