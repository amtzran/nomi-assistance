<!-- MODAL REPORT -->
<div class="modal fade" id="modalReportEmployeeAssistance" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="{{ Route('export_report_by_employee')}}" role="form">
            {{ csrf_field() }}
                <!-- Modal body -->
                <div class="modal-body">
                        <h4 class="modal-title">Reporte de Asistencias por Empleado</h4>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col form-check">
                                    <select name="selectEmployees" id="selectEmployees" class="form-control">
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
                            <div class="row">
                                <div class="col form-check">
                                    <select name="selectType" id="selectType" class="form-control">
                                        <option value="pdf">REPORTE EN PDF</option>
                                        <option value="excel">REPORTE EN EXCEL</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" id="btnExportReportEmployee" class="btn btn-dark">Descargar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
