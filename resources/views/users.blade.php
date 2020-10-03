@extends('layouts.app')

@section('content')

    <div class="col-12">
        <h4>Usuarios App</h4>
        <br>
        <div class="row">
            <div class="col-md-2 col-md-push-3">
                <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Nuevo Usuario</button>
            </div>
        </div>
        <!-- INICIA MODAL PARA INSCRIBIR -->
        <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ Route('createUser') }}"
                              role="form">
                            {{ csrf_field() }}
                            <label for="name">Nombre</label>
                            <input type="text" id="name" class="form-control" name="name" required="required">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" class="form-control" name="email" required="required">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" class="form-control" name="password" required="required">
                            <label for="rol">Rol</label>
                            <select name="rol" id="rol" class="form-control">
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">Encargado</option>
                                <option value="3">Auxiliar</option>
                            </select>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" id="userNew">Registrar</button>
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
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Miembro Desde</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if($user->id_rol == 1)
                            <td>Administrador</td>
                        @elseif($user->id_rol == 2)
                            <td>Encargado</td>
                        @else
                            <td>Auxiliar</td>
                        @endif
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>

@endsection

