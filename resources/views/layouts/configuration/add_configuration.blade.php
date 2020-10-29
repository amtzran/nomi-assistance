<!-- INICIA MODAL PARA GUARDAR EMPLEADO MANUAL -->
<div class="modal fade" id="myModalTurn" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title-employee">Nuevo Turno</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" role="form">
                        {{ csrf_field() }}
                        <label for="nombre_turno">Turno</label>
                        <input type="text" id="nombre_turno" class="form-control" name="nombre_turno" placeholder="Matutino/Vespertino" required="required">
                        <label for="hora_entrada">Hora Entrada</label>
                        <input type="time" id="hora_entrada" class="form-control" name="hora_entrada" placeholder="Registrar Hora Entrada" required="required">
                        <label for="hora_salida">Hora Salida</label>
                        <label for="nombre">Nombre</label>
                        <input type="time" id="hora_salida" class="form-control" name="hora_salida" placeholder="Registrar Hora Salida" required="required">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="turnNew">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- TERMINA MODAL-->