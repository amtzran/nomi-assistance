@extends('layouts.app')

@section('personal-js')
<script type="text/javascript" src="{{ asset('/js/branch_offices/validation.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/branchs.js') }}"></script>
@endsection
@section('content')
    <div class="col-12">
        <h4>Sucursales</h4>
        <br>
        @if(session('success'))
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-success alert-dismissible text-center btn-block">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ session('success') }}</strong>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Importar Datos</button>
            </div>
            <div class="col-md-8 col-md-pull-9">
                <a id="btnExportBranch" name="btnExportBranch" href="{{ route('export_branch') }}" class="btn btn-dark">Exportar Datos</a>
            </div>
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#myModalBranch">Ingresar Nueva Sucursal</button>
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
                            <label for="branch">Seleccionar archivo excel</label>
                            <input class="form-control btn" type="file" id="branch" name="branch" multiple>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- TERMINA MODAL PARA ELIMINAR REGISTRO -->
        <!-- Modal para guardar sucursal Manual -->
        @include('layouts.branch.add_branch')
        <br>
        <div class="table-responsive-md">
            <table class="table table-hover">
                <thead>
                <tr class="table-primary">
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                </tr>
                </thead>

                <tbody>
                @php($a = 0)
                @foreach($branch as $bra)
                    @php($a = $bra->id)
                    <tr>
                        <td>{{ $bra->clave }}</td>
                        <td>{{ $bra->nombre }}</td>
                        <td>
                            @csrf
                            @method('DELETE')
                            <!-- Modal para editar sucursal Manual -->
                            @include('layouts.branch.edit_branch')
                            <a data-toggle="modal" data-target="#myModalBranchEdit{{ $a }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                            <!-- Modal para eliminar sucursal Manual -->
                            @include('layouts.branch.delete_branch')
                            <a data-toggle="modal" data-target="#myModalBranchDelete{{ $a }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $branch->links() }}
    </div>
@endsection
