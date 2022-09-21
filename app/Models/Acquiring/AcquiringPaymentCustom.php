<?php

namespace App\Models\Acquiring;

use App\Models\Purchases;
use App\Models\Shop;
use Avlyalin\SberbankAcquiring\Models\AcquiringPayment;

class AcquiringPaymentCustom extends AcquiringPayment
{
    protected $fillable = [
        'bank_order_id',
        'status_id',
        'system_id',
        'payment_type',
        'payment_id',
        'notification',
    ];

    private function getBankUrl()
    {
        $url = parse_url($this->payment->bank_form_url);

        return (isset($url['scheme']) ? $url['scheme'] : 'https') . '://' . (isset($url['host']) ? $url['host'] : '');
    }

    public function getLinkBankTransaction()
    {
        return $this->getBankUrl() . '/mportal3/admin/orders/' . $this->bank_order_id;
    }

    public function purchases()
    {
        return $this->hasOne(Purchases::class, 'payment_id');
    }

    public function shop()
    {
        $shop_table = (new Shop)->getTable();
        $purchase_table = (new Purchases)->getTable();
        return $this->purchases()->join($shop_table, $shop_table . '.id', '=', $purchase_table . '.shop_id');
    }

}
