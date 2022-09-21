<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'sv_products';
    protected $fillable = [
        'title',
        'code',
        'amount',
        'description',
        'measure',
        'shop_id',
        'user_id',
        'deleted_at',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function payLink()
    {
        $params = http_build_query([
            'token' => $this->shop->token,
            'product' => $this->code,
            'modal' => 'false',
        ]);

        return Request::root() . '/payform/?' . $params;
    }

    public function getCurrencyAttribute()
    {
        return 'руб.';
    }

    public function getPayPrice()
    {
        return $this->amount * 100;
    }

    public function getPriceAttribute()
    {
        return $this->amount ? $this->amount . ' ' . $this->currency : null;
    }
}
