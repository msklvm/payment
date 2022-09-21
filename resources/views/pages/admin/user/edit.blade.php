@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Редактировать</h4>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-fw">Back</a>

                    {!! Form::model($user, ['method' => 'PUT','route' => ['user.update', $user->id], 'class' => 'form-horizontal', 'id' => 'user-form']) !!}
                    @includeIf('pages.admin.user.form', ['user' => $user, 'pass' => false])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Изменить пароль</h4>

                    {!! Form::model($user, ['method' => 'PUT','route' => ['user.password', $user->id], 'class' => 'form-horizontal', 'id' => 'password-form']) !!}
                    @includeIf('pages.admin.user.password')

                    <div class="form-group">
                        {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
