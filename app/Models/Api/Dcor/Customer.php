<?php

namespace App\Models\Api\Dcor;

use App\Api\Dcor\DcorApi;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function jsonToObject(array $data)
    {
        foreach ($data as $key => $val) {
            $this->attributes[$key] = $val;
        }

        return $this;
    }


    public function has(): bool
    {
        if (isset($this->contract_number) && !empty($this->contract_number)) {
            return true;
        }
        return false;
    }

    /**
     * Номер договора
     *
     * @return string
     */
    public function getContractAttribute()
    {
        return $this->contract_number;
    }

    /**
     * ФИО ученика
     *
     * @return string
     */
    public function getListenerAttribute()
    {
        return $this->listener_full_name;
    }

    /**
     * ФИО родителя
     *
     * @return string
     */
    public function getParentAttribute()
    {
        return $this->customer_full_name;
    }

    /**
     * Телефон родителя
     *
     * @return string
     */
    public function getPhoneAttribute()
    {
        return $this->customer_phone_number;
    }

    /**
     * Email родителя
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->customer_email;
    }

    public function scopeContract($builder, DcorApi $api)
    {
        return $this->jsonToObject(json_decode($api->contract()->request(), true));
    }
}
