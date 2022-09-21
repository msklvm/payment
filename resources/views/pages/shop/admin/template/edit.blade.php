@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Редактировать форму</h4>
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary btn-fw">Back</a>
                    {!! Form::open(['method' => 'POST','route' => ['shop.form_update', 'shop'=> $shop->id], 'class' => 'form-horizontal']) !!}
                    @includeIf('pages.shop.admin.template.form',['shop' => $shop, 'html' => $html])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
