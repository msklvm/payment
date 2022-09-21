@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Добавить пользователя</h4>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-fw">Back</a>

                    {!! Form::open(['method' => 'POST','route' => 'user.store', 'class' => 'form-horizontal']) !!}
                    @csrf
                    @includeIf('pages.admin.user.form', ['pass' => true])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
