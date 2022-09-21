@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Добавить роль</h4>
                    <a href="{{ route('role.index') }}" class="btn btn-secondary btn-fw">Back</a>

                    {!! Form::open(['method' => 'POST','route' => 'role.store', 'class' => 'form-horizontal']) !!}
                    @csrf
                    @includeIf('pages.admin.role.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
