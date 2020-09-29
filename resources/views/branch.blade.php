@extends('layouts.app')

@section('content')
    <div class="col-12">
        <h4>Sucursales</h4>
        <br>
        <div class="row">
            <div class="col-md-1 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div>
            <div class="col-md-11 col-md-pull-9">
                <a href="{{ route('export_branch') }}" class="btn btn-dark">Exportar Datos</a>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ Route('branch_file_upload') }}"
                              role="form">
                            {{ csrf_field() }}
                            <label for="branch">Seleccionar archivo csv</label>
                            <input type="file" id="branch" name="branch" accept=".csv" required="required">
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
        <div>
            <table class="table table-hover">
                <thead>
                <tr >
                    <th>Clave</th>
                    <th>Nombre</th>
                </tr>
                </thead>

                <tbody>
                @foreach($branch as $bra)
                    <tr>
                        <td>{{ $bra->clave }}</td>
                        <td>{{ $bra->nombre }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $branch->links() }}
    </div>
@endsection
