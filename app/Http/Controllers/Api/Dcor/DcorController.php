<?php

namespace App\Http\Controllers\Api\Dcor;

use App\Api\Dcor\DcorApi;
use App\Http\Controllers\Controller;
use App\Models\Api\Dcor\Customer;
use Illuminate\Http\Request;

class DcorController extends Controller
{
    public function index(Request $request, DcorApi $api)
    {
        return response()->json(Customer::contract($api), 200, [], JSON_UNESCAPED_UNICODE);
    }

}
