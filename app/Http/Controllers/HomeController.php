<?php

namespace App\Http\Controllers;

use App\Models\Shop;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $statics = [
            'total_revenue' => 0,
            'total_orders_complete' => 0,
            'total_orders' => 0,
        ];

        $shops = Shop::allowed()->payments()->get();

        foreach ($shops as $shop) {
            $statics['total_revenue'] += $shop->totalRevenue;
            $statics['total_orders_complete'] = $shop->orderComplete;

            /*foreach ($shop->purchase as $item) {
                $statics['total_orders']++;
                if ($item->payment->status_id == 4) {
                }
            }*/
        }

//        dd($statics);


        return view('dashboard', compact('statics'));
    }
}
