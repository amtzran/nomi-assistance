@extends('welcome')

@section('content')
    <div class="col-12">
        <h4>Asistencias</h4>
        <br>
        <div class="row text-left">
            <div class="col-md-6 text-center">
                <a class="btn btn-dark" data-toggle="modal" data-target="#myModalReport">Reporte Asistencias</a>
            </div>
            <div class="col-md-6 text-center">
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#modalHourExtraReport">Reporte Horas Extra</a>
            </div>
            <div class="col-md-6 text-center">
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#modalReportEmployeeAssistance">Reporte Asistencia Empleado</a>
            </div>
        </div>
        @include('modals.modalAssistanceExcel')
        @include('modals.modalReportAssistance')
        @include('modals.modalHourExtraReport')
        @include('modals.modalEmployeeReport')
        <br>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="table-primary">
                    <th>Clave</th>
                    <th>Nss</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Asistencia</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                    <th>Fecha</th>
                    <th>Geolocalización</th>
                </tr>
                <tr class="table-primary">
                    <th><input type="text" name="keyAssistance" id="keyAssistance" class="form-control"></th>
                    <th><input type="text" name="nssAssistance" id="nssAssistance" class="form-control"></th>
                    <th><input type="text" name="nameAssistance" id="nameAssistance" class="form-control"></th>
                    <th><input type="text" name="lastNameAssistance" id="lastNameAssistance" class="form-control"></th>
                    <th><select id="selectTypeAssistance" class="form-control">
                            <option value="0" selected>Todos</option>
                            @foreach($absences as $absence)
                                <option value="{{ $absence->id }}">{{ $absence->nombre }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th><input class="form-control" type="time" name="hourInAssistance" id="hourInAssistance"></th>
                    <th><input class="form-control" type="time" name="hourOutAssistance" id="hourOutAssistance"></th>
                    <th><input class="form-control" type="text" name="filterDateAssistance" id="filterDateAssistance"></th>
                    <th><button class="btn btn-dark" id="btnFilterAssistance">Buscar</button></th>
                </tr>
                </thead>

                <tbody>
                @foreach($assistance as $assist)
                    <tr>
                        <td>{{ $assist->clave }}</td>
                        <td>{{ $assist->nss }}</td>
                        <td>{{ $assist->nombre }}</td>
                        <td>{{ $assist->apellido_paterno }}</td>
                        <td>{{ $assist->nombre_incidencia }}</td>
                        <td>{{ $assist->hora_entrada }}</td>
                        <td>{{ $assist->hora_salida }}</td>
                        <td>{{ $assist->fecha_entrada }}</td>
                        <td><a target="_blank" class="btn btn-outline-secondary" href="https://www.google.com/maps/place/{{ $assist->geolocalizacion }}"><i class="fas fa-map-marked-alt"></i> Punto de Asistencia</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $assistance->links() }}
    </div>
@endsection
@section('personal-js')
    <script type="text/javascript" src="{{ asset('/js/assistances.js') }}"></script>
<!--    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>-->
<!--    <script>
            $('.select-employees').select2();
    </script>-->
@endsection
