@extends('layout.master')

@push('plugin-styles')
    {!! Html::style('/assets/plugins/datatables/css/dataTables.bootstrap.min.css') !!}
    {!! Html::style('/assets/plugins/datatables/css/jquery.dataTables.css') !!}
@endpush

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Заказы: @if($shop){{ $shop->title }}@endif</h4>

                    {{--<form action="{{ route('order.show', request()->route('order')) }}" method="GET">
                        <div class="row">
                            <div class="col">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Статус</option>
                                    @foreach(\Avlyalin\SberbankAcquiring\Models\AcquiringPaymentStatus::select(['id', 'name'])->get()->pluck('name','id') as $id=>$title)
                                        <option value="{{ $id }}"
                                                @if(request()->get('status') == $id) selected @endif>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-outline-success w-100 h-100">Filter</button>
                            </div>
                        </div>
                    </form>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                @if($orders)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Date created</th>
                                    <th>Status</th>
                                    <th>bank_order_id</th>
                                    <th>amount</th>
                                    <th>Checkout</th>
                                    <th>json_params</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders->purchase as $purchase)
                                    @if ($purchase->payment)
                                        <tr>
                                            <td>{{ $purchase->payInfo()->id }}</td>
                                            <td title="{{ $purchase->payInfo()->description }}">{{ \Illuminate\Support\Str::limit($purchase->payInfo()->description, 30) }}</td>
                                            <td>{{ $purchase->payment->created_at }}</td>
                                            <td>{{ $purchase->payment->status->name }}</td>
                                            <td>
                                                <a href="{{ $purchase->payment->getLinkBankTransaction() }}"
                                                   target="_blank">
                                                    {{ $purchase->payment->bank_order_id }}
                                                </a>
                                            </td>
                                            <td>{{ number_format($purchase->payInfo()->amount / 100, 2) }} руб.</td>

                                            <td>
                                                <a href="{{ route('checkout',['orderId'=>$purchase->payment->bank_order_id]) }}"
                                                   target="_blank">Чек</a>
                                            </td>

                                            <td>
                                                <ul>
                                                    @foreach($purchase->payJsonParam() as $name=> $param)
                                                        <li>{{ $name }} - {{ $param }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        Нет данных
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('plugin-scripts')
    {!! Html::script('/assets/plugins/datatables/js/jquery.dataTables.min.js') !!}

    <script>
        jQuery(document).ready(function ($) {
            var table = $('.table').DataTable({})
        });
    </script>

@endpush
