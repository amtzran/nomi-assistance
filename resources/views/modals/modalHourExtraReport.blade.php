<!-- MODAL REPORT -->
<div class="modal fade" id="modalHourExtraReport" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <div class="modal-body">
                        <h4 class="modal-title">Horas Extras</h4>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col form-check">
                                    <select name="selectEmployees" id="selectEmployees" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->nombre}} {{ $employee->apellido_paterno }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <label for="assistance">Seleccionar Fecha Inicial y Final</label>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <input type="date" id="date_initial_hour" name="date_initial_hour" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <input type="date" id="date_final_hour" name="date_final_hour" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <label for="">Total Horas: <b id="labelHours" class="text-primary">0</b></label>

                            <label for="">Total Minutos: <b id="labelMinutes" class="text-primary">0</b></label>

                            <div class="table-responsive">
                                <table class="table table-hover" id="tableBodyExtraReport">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>Clave</th>
                                        <th>Nss</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                        <th>Fecha</th>
                                        <th>Horas Extras</th>
                                        <th>Minutos Extras</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>

                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" id="btnCalculate" class="btn btn-dark">Calcular</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="btnExportHour" class="btn btn-dark">Extraer</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>