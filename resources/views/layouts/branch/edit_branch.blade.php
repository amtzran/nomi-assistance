<!-- INICIA MODAL PARA EDITAR SUCURSAL MANUAL -->
<div class="modal fade" id="myModalBranchEdit{{ $a }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-branch">Editar Sucursal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            <form action="{{ Route('updateBranch') }}" method="POST" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="number" name="id" value="{{ $bra->id }}" hidden="hidden">
                    <label for="clave">Clave</label>
                    <input type="text" id="clave" class="form-control" name="clave" required="required" value="{{ $bra->clave }}" disabled="disabled">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" class="form-control" name="nombre" required="required" value="{{ $bra->nombre }}">
                        <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" id="branchEdit">Actualizar</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- TERMINA MODAL-->