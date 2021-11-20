<!-- MODAL REPORT -->
<div class="modal fade" id="myModalReport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4 class="modal-title">Reporte</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <form method="POST" enctype="multipart/form-data" action="{{ Route('export_assistance')}}" role="form">
                    {{ csrf_field() }}
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col form-check">
                                <input class="form-check-input" type="radio" name="radioReport" id="todayRadio" value="today" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Hoy
                                </label>
                            </div>
                            <div class="col form-check">
                                <input class="form-check-input" type="radio" name="radioReport" id="allRadio" value="all">
                                <label class="form-check-label" for="exampleRadios2">
                                    Todo
                                </label>
                            </div>
                            <div class="col form-check mb-2">
                                <input class="form-check-input" type="radio" name="radioReport" id="dateRadio" value="option3">
                                <label class="form-check-label" for="exampleRadios3">
                                    Fecha
                                </label>
                            </div>
                        </div>
                    </div>
                    <label for="assistance">Seleccionar Fecha Inicial y Final</label>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <input type="date" id="date_initial" name="date_initial" class="form-control">
                            </div>
                            <div class="col">
                                <input type="date" id="date_final" name="date_final" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Extraer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>