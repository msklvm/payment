<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Filters\Shop\OrderFilter;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, OrderFilter $filter)
    {
        return redirect()->home();
    }

    public function show($id, Request $request, OrderFilter $filter)
    {
        $shop = Shop::select(['id','title'])->whereId($id)->allowed()->firstOrFail();

        $orders = Shop::whereId($id)->allowed()->filter($filter)->with(['purchase'=> function ($q) {
            return $q->with(['payment' => function ($q1) {
                return $q1->with('payment:id,description,bank_form_url,bank_form_url,json_params,amount','status');
            }]);
        }])->first();

        return view('pages.shop.order.index', compact('shop', 'orders'));
    }
}
