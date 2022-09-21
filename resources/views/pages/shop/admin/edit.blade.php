@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Редактировать</h4>
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary btn-fw">Back</a>
                    {!! Form::model($shop, ['method' => 'PUT','route' => ['shop.update', $shop->id], 'class' => 'form-horizontal', 'id' => 'shop-form', 'files' => true]) !!}
                    @includeIf('pages.shop.admin.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
