<!-- INICIA MODAL PARA EDITAR EMPLEADO MANUAL -->
<div class="modal fade" id="myModalTurnEdit{{ $a }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-employee">Editar Turno</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            <form action="{{ Route('updateTurn') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <input type="number" name="id" value="{{ $turn->id }}" hidden="hidden">
                    <label for="nombre_turno">Turno</label>
                    <input type="text" id="nombre_turno" class="form-control" name="nombre_turno" required="required" value="{{ $turn->nombre_turno }}">
                    <label for="hora_entrada">Hora Entrada</label>
                    <input type="time" id="hora_entrada" class="form-control" name="hora_entrada" required="required" value="{{ $turn->hora_entrada }}">
                    <label for="hora_salida">Hora Salida</label>
                    <input type="time" id="hora_salida" class="form-control" name="hora_salida" required="required" value="{{ $turn->hora_salida }}">
                     <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" id="turnEdit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- TERMINA MODAL-->