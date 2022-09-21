@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Users</h4>

                    <a href="{{ route('user.create') }}" class="btn btn-success">
                        Добавить <i class="mdi mdi-plus"></i>
                    </a>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Permissions</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <label class="badge badge-danger">{{ $role->name }}</label>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($user->permissions as $permission)
                                            <label class="badge badge-danger">{{ $permission->name }}</label>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
