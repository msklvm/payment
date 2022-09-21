@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Добавить товар</h4>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary btn-fw">Back</a>
                    {!! Form::open(['method' => 'POST','route' => 'product.store', 'class' => 'form-horizontal']) !!}
                    @includeIf('pages.shop.product.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection()
