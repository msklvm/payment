@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Редактировать</h4>
                    <a href="{{ route('role.index') }}" class="btn btn-secondary btn-fw">Back</a>

                    {!! Form::model($role, ['method' => 'PUT','route' => ['role.update', $role->id], 'class' => 'form-horizontal', 'id' => 'role-form']) !!}
                    @includeIf('pages.admin.role.form', ['user' => $role])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
