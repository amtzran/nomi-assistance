<!-- INICIA MODAL PARA INSCRIBIR -->
<div class="modal fade" id="myModalBranch" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar sucursal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" role="form">
                        {{ csrf_field() }}
                        <label for="clave">Clave</label>
                        <input type="text" id="clave" class="form-control" name="clave" placeholder="Clave de la sucursal (Catalgo)" required="required">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombre de la sucursal (Catalgo)" required="required">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="branchNew">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- TERMINA MODAL PARA ELIMINAR REGISTRO -->