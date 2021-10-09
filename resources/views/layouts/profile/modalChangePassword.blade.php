<!-- INICIA MODAL PARA GUARDAR EMPLEADO MANUAL -->
<div class="modal fade" id="modalChangePassword" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-employee">Cambiar Contraseña</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" role="form">
                    {{ csrf_field() }}
                    <label for="newPassword">Nueva Contraseña</label>
                    <input type="password" id="newPassword" class="form-control" required="required">
                    <label for="confirmPassword">Confirmar Contraseña</label>
                    <input type="password" id="confirmPassword" class="form-control" required="required">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" id="btnChangePassword">Cambiar</button>
            </div>
        </div>
    </div>
</div>
<!-- TERMINA MODAL-->