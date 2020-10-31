@extends('welcome')

@section('content')
    <div class="col-12">
        <h4>Asistencias</h4>
        <br>
        <div class="row text-left">
            <!-- <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div> -->
            <div class="col-md-6 col-md-pull-9">
                <a href="{{ route('export_assistance') }}" class="btn btn-dark">Exportar Datos</a>
            </div>
            <div class="col-md-6 col-md-pull-9">
                <a class="btn btn-dark" data-toggle="modal" data-target="#myModalReport">Reporte</a>
            </div>
        </div>
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
        <br>
        <div class="table-responsive-md">
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
