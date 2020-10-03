@extends('welcome')

@section('content')
    <div class="col-12">
        <h4>Asistencias</h4>
        <br>
        <div class="row">
            <!-- <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div> -->
            <div class="col-md-10 col-md-pull-9">
                <a href="{{ route('export_assistance') }}" class="btn btn-dark">Exportar Datos</a>
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
                            <label for="assistance">Seleccionar archivo csv</label>
                            <input type="file" id="assistance" name="assistance" accept=".csv" required="required">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- TERMINA MODAL PARA ELIMINAR REGISTRO -->

        <br>
        <div class="table-responsive-md">
            <table class="table table-hover">
                <thead>
                <tr class="table-primary">
                    <th>Clave</th>
                    <th>Asistencia</th>
                    <th>Fecha</th>
                </tr>
                </thead>

                <tbody>
                @foreach($assistance as $assist)
                    <tr>
                        <td>{{ $assist->id_empleado }}</td>
                        <td>{{ $assist->asistencia }}</td>
                        <td>{{ $assist->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $assistance->links() }}
    </div>
@endsection
