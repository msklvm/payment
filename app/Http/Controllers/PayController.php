<?php

namespace App\Http\Controllers;

use App\Models\Acquiring\AcquiringPaymentCustom;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchases;
use App\Models\Shop;
use Avlyalin\SberbankAcquiring\Exceptions\HttpClientException;
use Avlyalin\SberbankAcquiring\Exceptions\JsonException;
use Avlyalin\SberbankAcquiring\Exceptions\NetworkException;
use Illuminate\Http\Request;
use Avlyalin\SberbankAcquiring\Client\HttpClientInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($this->validation($request)->fails())
            abort(404, 'Not Found Shop');

        $code = $request->get('product');
        $token = $request->get('token');

        $product = Product::select(['id', 'title', 'amount', 'code'])->where('code', $code)->firstOrFail();
        $shop = Shop::select(['id', 'title', 'token', 'api_login', 'api_password', 'api_login_test', 'api_password_test', 'api_token', 'view'])->where('token', $token)->firstOrFail();

        $shop->checkMerchant();

        $product->token = $shop->token;

        $view = "outside.pay.template." . $shop->view;

        if (!View::exists($view)) {
            $view = 'outside.pay.template.default';
        }
        $template = $view;

        return view('outside.pay.main', compact('product', 'shop', 'template'));
    }

    function pay(Request $request)
    {
        if ($this->validation($request)->fails())
            abort(404, 'Not Found Shop');

        $product = Product::where('code', $request->get('product'))->firstOrFail();

        $shop = Shop::where('token', $request->get('token'))->firstOrFail();
        $shop->checkMerchant();

        $order = new Order($shop, $product);
        $payment = $order->register($request);

        if (isset($payment->bank_form_url)) {
            header('Location: ' . $payment->bank_form_url);
            exit;
        } else {
            abort(404, "Bank from url not found. Check credential.");
        }
    }


    public function checkout(Request $request)
    {
        if (!$request->has('orderId')) {
            return null;
        } else {
            return view('outside.pay.checkout');
        }
    }

    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'token' => 'required',
            'product' => 'required',
        ]);
    }

    public function details(Request $request)
    {
        $params = null;
        $errors = null;

        $orderPayment = AcquiringPaymentCustom::select(['id'])->where('bank_order_id', $request->get('orderId'))->first();
        $purchase = Purchases::with('shop')->where('payment_id', $orderPayment->id)->first();

        if (!$purchase) {
            return null;
        }

        $shop = $purchase->shop;

        if (!$shop) {
            return null;
        }

        $apiClient = $shop->apiClient();

        try {
            $response = $apiClient->getOrderStatusExtended(
                [
                    'orderId' => $request->get('orderId'),
                    'language' => $request->get('lang'),
                ],
                HttpClientInterface::METHOD_POST, // метод запроса
                ['Cache-Control' => 'no-cache'] // хэдеры запроса
            );
        } catch (HttpClientException $e) {
        } catch (NetworkException $e) {
        }

        try {
            if ($response->isOk()) {
                $params = $response->getResponseArray();
                $orderPayment->update(['status_id' => $params['orderStatus'], 'notification' => 1]);

                //            $status = rand(1, 6);
                //            $orderPayment->update(['status_id' => $status]);
            } else {
                $errors = $response->getErrorMessage();
            }
        } catch (JsonException $e) {
            $errors = $e->getMessage();
        }

        return response()->json([
            'params' => $params,
            'errors' => $errors,
        ]);
    }

}
