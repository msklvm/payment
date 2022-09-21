<?php


namespace App\Models;


use Avlyalin\SberbankAcquiring\Client\HttpClientInterface;
use Avlyalin\SberbankAcquiring\Exceptions\AcquiringException;
use Avlyalin\SberbankAcquiring\Exceptions\JsonException;
use Avlyalin\SberbankAcquiring\Exceptions\ResponseProcessingException;
use Avlyalin\SberbankAcquiring\Models\SberbankPayment;
use Illuminate\Http\Request;

/*Для создания заказа*/

class Order
{
    private $shop;
    private $product;
    private $params;
    private $order_number;

    public function __construct(Shop $shop, Product $product)
    {
        $this->shop = $shop;
        $this->product = $product;
        $this->order_number = rand(1, 10000) . "-" . time();
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    public function register(Request $request): SberbankPayment
    {
        $this->params = $this->getParams($request);

        $client = $this->shop->createClient();

        if ($request->has('amount') && is_null($this->product->amount)) {
            $this->product->amount = $request->get('amount');
        }

        try {
            $acquiringPayment = $client->register(
                $this->product->getPayPrice(),
                $this->billingData(),
                HttpClientInterface::METHOD_POST,
                [
                    'Cache-Control' => 'no-cache'
                ]
            );
        } catch (JsonException $e) {
            abort(404, $e->getMessage());
        } catch (ResponseProcessingException $e) {
            abort(404, $e->getMessage());
        } catch (AcquiringException $e) {
            abort(404, $e->getMessage());
        } catch (\Throwable $e) {
            abort(404, $e->getMessage());
        }

        $payment = $acquiringPayment->payment()->select('bank_form_url')->firstOrFail();
        $this->shop->setPurchase($acquiringPayment->id);

        return $payment;
    }

    private function billingData(): array
    {
        $billingData = [
            'orderNumber' => $this->order_number,
            'jsonParams' => json_encode($this->params)
        ];

        $billingData['returnUrl'] = $this->shop->return_url;
        $billingData['failUrl'] = $this->shop->fail_url;

//        $quantity = $product->count();
        // TODO Разширить класс для добавлении корзины avlyalin\laravel-sberbank-acquiring\src\Models\SberbankPayment.php
        $order_bundle = array(
            /*    'orderCreationDate' => Carbon::now()->getTimestamp(),
                'cartItems' => array('items' => [
                    'name' => '',
                    'quantity' => array(
                        'value' => $quantity,
                        'measure' => $product->measure
                    ),
                    'itemAmount' => $amount * $quantity,
                    'itemCode' => $product->code
                ]),*/
            'description' => $this->product->title
        );

        return array_merge($billingData, $order_bundle);
    }

    private function getParams(Request $request): array
    {
        $this->params = $request->get('jsonParam');

        return $this->params;
    }

}
