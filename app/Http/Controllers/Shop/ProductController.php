<?php

namespace App\Http\Controllers\Shop;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $shops = Shop::with('products')->allowed()->get();

        return view('pages.shop.product.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.shop.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $this->validation($input);

        if ($fails = $validator->fails()) {
            $messages = $validator->errors()->first();
            alert()->error($messages);
            return redirect()->back();
        }

        $input['user_id'] = auth()->user()->getAuthIdentifier();
        $input['code'] = Str::random(15);

        $product = Product::create($input);

        if ($product) {
            alert()->success('Product added');
        } else {
            alert()->success('Error adding product');
            return back();
        }

        return redirect()->route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('pages.shop.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $validator = $this->validation($input);

        if ($fails = $validator->fails()) {
            $messages = $validator->errors()->first();
            alert()->error($messages);
            return redirect()->back();
        }

        $product->update($input);

        alert()->success('Обновлено');

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product)
    {
        if (!$product->delete())
            alert()->error('Ошибка удаления');

        alert()->success('Удалено');

        return redirect(route('product.index'));
    }

    public function validation($input)
    {
        return Validator::make($input, [
            'shop_id' => 'required',
            'title' => 'required|string',
//            'amount' => 'required'
        ]);
    }
}
