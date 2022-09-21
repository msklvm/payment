@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Roles</h4>

                    <a href="{{ route('role.create') }}" class="btn btn-primary">Добавить role</a>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>

                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="">
                                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-secondary">
                                                Edit
                                            </a>
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger">
                                                    <i class="mdi mdi-delete"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
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
