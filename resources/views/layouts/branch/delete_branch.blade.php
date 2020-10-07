<!-- INICIA MODAL PARA ELIMINAR SUCURSAL MANUAL -->
<div class="modal fade" id="myModalBranchDelete{{ $a }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-branch">¿Estás seguro que quieres eliminar la Sucursal?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            <form action="{{ Route('deleteBranch') }}" method="post" id="form">
                    {{ csrf_field() }}
                    <input type="number" name="id" value="{{ $bra->id }}" hidden="hidden">
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