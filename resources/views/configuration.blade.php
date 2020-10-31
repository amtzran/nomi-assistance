@extends('layouts.app')
@section('personal-js')
    <script type="text/javascript" src="{{ asset('/js/configurations.js') }}"></script>
@endsection
@section('content')

    <div class="col-12">
        <h4>Configuraciones</h4>
        <br>
        @if(session('success'))
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-success alert-dismissible fade show">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ session('success') }}</strong>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#myModalTurn">Ingresar Nuevo Turno</button>
            </div>
        </div>
        <br>
        <!-- TERMINA MODAL -->
        <!-- Modal para guardar empleado Manual -->
        @include('layouts.configuration.add_configuration')
        <br>
            <div class="table-responsive-md">
                <table class="table table-hover table-borderless" id="#tableData">
                    <thead>
                    <tr class="table-primary">
                        <th>Turno</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php($a = 0)
                    @foreach($turns as $turn)
                        @php($a = $turn->id)
                        <tr>
                            <td>{{ $turn->nombre_turno }}</td>
                            <td>{{ $turn->hora_entrada }}</td>
                            <td>{{ $turn->hora_salida }}</td>
                            <td>
                                @csrf
                                @method('DELETE')
                                <!-- Modal para editar empleado Manual -->
                                @include('layouts.configuration.edit_configuration')
                                <a data-toggle="modal" data-target="#myModalTurnEdit{{ $a }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                                <!-- Modal para eliminar empleado Manual -->
                                @include('layouts.configuration.delete_configuration')
                                <a data-toggle="modal" data-target="#myModalTurnDelete{{ $a }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        {{ $turns->links() }}
        </div>

@endsection
