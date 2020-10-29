<!-- INICIA MODAL PARA ELIMINAR SUCURSAL MANUAL -->
<div class="modal fade" id="myModalTurnDelete{{ $a }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-employee">¿Estás seguro que quieres eliminar el Turno?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            <form action="{{ Route('deleteTurn') }}" method="post" id="form">
                    {{ csrf_field() }}
                    <input type="number" name="id" value="{{ $turn->id }}" hidden="hidden">
                        <h6 class="modal-title-employee">Al Eliminar el turno los empleados asociados dejaran de aparecer</h6>
                        <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- TERMINA MODAL-->