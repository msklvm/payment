@extends("layout.master")

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Редактировать</h4>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary btn-fw">Back</a>
                    {!! Form::model($product, ['method' => 'PUT','route' => ['product.update', $product->id], 'class' => 'form-horizontal', 'id' => 'product-form']) !!}
                    @includeIf('pages.shop.product.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection()
