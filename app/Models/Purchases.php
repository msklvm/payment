<?php


namespace App\Models;


use App\Models\Acquiring\AcquiringPaymentCustom;
use Avlyalin\SberbankAcquiring\Models\SberbankPayment;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $table = 'sv_shop_purchases';
    protected $fillable = [
        'shop_id',
        'payment_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function payment()
    {
        return $this->belongsTo(AcquiringPaymentCustom::class);
    }

    public function payments()
    {
        return $this->belongsToMany(AcquiringPaymentCustom::class, SberbankPayment::class, 'id',
            'id', 'id', 'id');
    }

    public function payInfo()
    {
        return $this->payment->payment;
    }

    public function payJsonParam()
    {
        $json = $this->payInfo()->json_params;

        if (empty($json))
            return [];

        $items = json_decode($json, true);

        if (count($items) > 0)
            return $items;

        return [];
    }

}
