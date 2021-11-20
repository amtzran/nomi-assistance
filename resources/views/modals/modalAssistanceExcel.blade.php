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
                <form method="POST" enctype="multipart/form-data" action="{{ Route('assistance_file_upload')
                        }}" role="form">
                    {{ csrf_field() }}
                    <label for="assistance">Seleccionar archivo excel</label>
                    <input type="file" id="assistance" name="assistance" required="required">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- TERMINA MODAL PARA ELIMINAR REGISTRO -->