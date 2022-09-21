<?php

namespace App\Mail;

use App\Models\Acquiring\AcquiringPaymentCustom;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPay extends Mailable
{
    use Queueable, SerializesModels;

    private $acquiringPayment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AcquiringPaymentCustom $acquiringPayment)
    {
        // new test
        $this->acquiringPayment = $acquiringPayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pay_data = $this->acquiringPayment->payment()->first();

        return $this->view('mails.orders.pay')->with([
            'shop' => $this->acquiringPayment->shop,
            'orderName' => $pay_data->description,
            'orderAmount' => number_format(($pay_data->amount / 100), 2) . 'руб.',
            'status' => $this->acquiringPayment->status()->first()->name,
            'bank_order_link' => $this->acquiringPayment->getLinkBankTransaction(),
            'bank_order_id' => $this->acquiringPayment->bank_order_id,
        ]);
    }
}
