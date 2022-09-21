@extends('layout.master')

@push('plugin-styles')
    <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-cube text-danger icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Общая прибыльь</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{ number_format($statics['total_revenue'], 0, '', ' ') }}
                                    руб.</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left d-none">
                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> 65% lower growth
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-receipt text-warning icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Заказы</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{ $statics['total_orders'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left d-none">
                        <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-poll-box text-success icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Завершенные заказы</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{ $statics['total_orders_complete'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left d-none">
                        <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card d-none">
            <div class="card card-statistics">
                <div class="card-body">
                    <div
                        class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                        <div class="float-left">
                            <i class="mdi mdi-account-box-multiple text-info icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Employees</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">246</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left d-none">
                        <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h2 class="card-title mb-0">FAQ</h2>
                    </div>
                    <div class="faq-container">
                        <p>Подключение</p>
                        <pre>&lt;script src="{{ url('/') }}/payment/js/svpay.js" type="text/javascript"&gt;&lt;/script&gt;
                                <br/>&lt;script type="text/javascript"&gt;var pay = new PAYConstructor({api_token:'SHOP_TOKEN'});&lt;/script&gt;</pre>
                        <p>Ссылка на оплату</p>
                        <pre>&lt;a href="#" class="btn btn-success" onclick="payCheckout({product: 'PRODUCT_CODE'})"&gt;Оплатить&lt;/a&gt;</pre>
                        <pre>&lt;a href="{{ url('/') }}/payform?token=SHOP_TOKEN&amp;product=PRODUCT_CODE"&gt;Купить&lt;/a&gt;</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
    {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
    {!! Html::script('/assets/js/dashboard.js') !!}
@endpush
