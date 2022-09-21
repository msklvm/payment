@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Добавить магазин</h4>
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary btn-fw">Back</a>
                    {!! Form::open(['method' => 'POST', 'route' => 'shop.store', 'class' => 'form-horizontal', 'files' => true]) !!}
                    @includeIf('pages.shop.admin.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection()
