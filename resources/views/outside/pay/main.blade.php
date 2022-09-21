@extends('outside.layout.master')

@section('content')
    @includeIf('outside.pay.form', ['template' => $template])
@endsection
