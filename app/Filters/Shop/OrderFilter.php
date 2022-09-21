<?php


namespace App\Filters\Shop;

use App\Filters\QueryFilter;
use  Illuminate\Database\Eloquent\Builder;

class OrderFilter extends QueryFilter
{
    public function id($value)
    {
        $this->builder->whereHas('purchase', function (Builder $q) use ($value) {
            $q->whereHas('payment', function (Builder $q1) use ($value) {
                $q1->where('payment_id', $value);
            });
        });
    }

    public function status($value)
    {
        $this->builder->whereHas('purchase' , function (Builder $q) use ($value) {
            return $q->with(['payment' => function (Builder $q1) use ($value) {
                return  $q1->where('id', $value);
            }]);
        });
    }

}
