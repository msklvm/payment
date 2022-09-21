<div class="load-block">
    <div class="loader"></div>
</div>

<div class="wrapper">
    @if(Request::has('modal') && Request::get('modal') == 'true' )
        <div class="l-wrapper-close">
            <button id="closeBtn" class="close-button" tabindex="1" aria-label="Закрыть"></button>
        </div>
    @endif
    <div class="l-header">
        <div class="l-header__inner">
            <div class="l-header__logos">
                <div class="logo"></div>
            </div>
            <div class="title">{{ $shop->title }}</div>
        </div>
    </div>
    <div>
        <form action="{{ route('pay') }}" class="js-pay-form">
            <input type="hidden" value="{{ $product->code }}" name="product">
            <input type="hidden" value="{{ $shop->token }}" name="token">

            <div class="enter-amount-block">
                <div class="clear">
                    <div class="left">
                        <div id="amountShow" class="left-pad">
                            @if ($product->amount)
                                <span class="amount">{{ $product->amount }} {{ $product->currency }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="description-block">
                <div class="left">
                    <div id="description_predefined_block" class="left-pad">
                        <div class="description">{{ $product->title }}</div>
                    </div>
                </div>
            </div>
            <hr>
            @if (!$product->amount)
                <div class="form-group">
                    <label for="amount">Сумма</label>
                    <input type="text" placeholder="Сумма" id="amount" class="form-control"
                           name="amount" required>
                </div>
            @endif
            <div class="form-group">
                <label for="orderEmail">E-mail</label>
                <input type="email" placeholder="Email" id="orderEmail" class="form-control"
                       name="jsonParam[email]" required>
            </div>
            <div class="form-group">
                <label for="orderPhone">Телефон</label>
                <input type="text" placeholder="Телефон" id="orderPhone" class="form-control"
                       name="jsonParam[phone]" required>
            </div>

            @includeIf($template)

            <div class="main-button-block clear">
                <div class="right">
                    <div class="ps-logos"></div>
                </div>
            </div>

            <div class="form-group text-center">
                <button class="btn btn-success btn-robo js-modal-pay-link" type="submit">
                    Перейти к оплате
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('payment/css/payform.css') }}">
<style>
    .l-header__logos .logo {
        background-image: url({{ $shop->getLogo() }});
    }
</style>
