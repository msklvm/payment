@extends('outside.layout.master')

@section('content')
    <div class="container">
        <div class="wrapper">
            <div class="l-wrapper-close">
                <button id="closeBtn" class="close-button" tabindex="1" aria-label="Закрыть"></button>
            </div>

            <div class="row">
                <div class="col-12">
                    <h3 class="text-center font-weight-bold font-size">Платеж принят в обработку</h3>
                </div>
            </div>

            <div class="load"></div>

            <div class="details d-none">
                <div class="row">
                    <div class="col">
                        <p class="orderDescription"></p>
                        <p>Стоимость: <strong class="amount"></strong> <strong>руб.</strong></p>
                        <p>Номер заказа: <strong class="orderNumber"></strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <img src="/payment/imgs/pay_ok.png" alt="pay status">
                </div>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('payment/css/payform.css') }}">

@endsection

@push('script')
    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        jQuery(document).ready(function ($) {
            $.post('{{ route('pay.details') }}', {orderId: '{{ request()->get('orderId') }}'}, function (response) {
                let load = $('.load');
                let details = $('.details');

                if (response) {
                    load.addClass('d-none');
                    details.removeClass('d-none');

                    if (response.errors == null) {
                        $('.orderDescription').text(response.params.orderDescription);
                        $('.amount').text(response.params.amount / 100);
                        $('.orderNumber').text(response.params.orderNumber);
                    }
                }
            });
        });
    </script>
@endpush
