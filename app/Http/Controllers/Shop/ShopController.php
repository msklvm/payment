<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $shops = Shop::allowed()->get();

        return view('pages.shop.admin.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Super admin'))
            return back();

        return view('pages.shop.admin.create');
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
        $input['token'] = Str::random(15);
        $input['view'] = Str::random(5);
        $input['user_id'] = auth()->user()->getAuthIdentifier();

        $validator = $this->validator($input);

        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        if ($request->has('logo')) {
            $logo = $this->uploadLogo($request);
            if (!$logo) {
                alert()->error('Error upload logo');
                return back();
            }
            $input['logo'] = $logo;
        }

        if ($request->has('emails_notification') && !is_null($input['emails_notification'])) {
            $input['emails_notification'] = $this->parseEmails($input['emails_notification']);
        }

        if ($shop = Shop::create($input)) {
            alert()->success('Shop added');
            $this->createAndSetPermission($shop);
        } else {
            alert()->success('Error added shop');
        }

        return redirect()->route('shop.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Shop $shop)
    {
        if ($this->checkPerm($shop))
            return back();

        return view('pages.shop.admin.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Shop $shop)
    {
        $input = $request->all();

        $validator = $this->validator($input);
        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        if ($request->has('logo')) {
            $logo = $this->uploadLogo($request);
            if (!$logo) {
                alert()->error('Error upload logo');
                return back();
            }
            $input['logo'] = $logo;
        }

        if ($request->has('emails_notification') && !is_null($input['emails_notification'])) {
            $input['emails_notification'] = $this->parseEmails($input['emails_notification']);
        }

        if ($shop->update($input)) {
            alert()->success('Updating');
        } else {
            alert()->error('Error Updating');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }

    public function logo($id)
    {
        $item = Shop::select('logo')->where('id', $id)->firstOrFail();

        $path = storage_path($item->logo);

        return response()->file($path);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'test_mode' => ['required'],
            'logo' => 'image|max:2024', // 2MB Max
        ]);
    }

    public function form(Shop $shop)
    {
        if ($this->checkPerm($shop))
            return back();

        $html = $shop->getViewForm()->toHtml();

        return view('pages.shop.admin.template.edit', compact('shop', 'html'));
    }

    public function form_update(Request $request, Shop $shop)
    {
        if ($this->checkPerm($shop))
            return back();

        $input = $request->all();

        if (strlen($input['html']) < 10) {
            alert()->error('Min len 10 char');
            return back();
        }

        $bladeForm = $shop->getViewForm();
        file_put_contents($bladeForm->getPath(), $input['html']);

        return back();
    }

    public function checkPerm(Shop $shop)
    {
        if (!auth()->user()->hasPermissionTo('shops.*') || !auth()->user()->hasPermissionTo('shops.*.' . $shop->id)) {
            alert()->warning('Not enough rights');

            return true;
        }

        return false;
    }

    public function uploadLogo(Request $request): string
    {
        $fileName = time() . '.' . $request->logo->extension();

        $path = 'app/public/logos';
        $file = $request->logo->move(storage_path($path), $fileName);

        if (!$file) {
            return false;
        }

        return $path . "/" . $fileName;
    }

    private function createAndSetPermission(Shop $shop)
    {
        $permission = Permission::create([
            'name' => 'shops.*.' . $shop->id,
            'guard_name' => 'web',
        ]);
        $permission->users()->attach($shop->user_id);
    }

    private function parseEmails(string $emls)
    {
        $emails = [];

        if (strlen($emls) > 5) {
            $emails_tmp = json_decode($emls);
            foreach ($emails_tmp as $mail) {
                array_push($emails, $mail->value);
            }
        }

        return implode(',', $emails);
    }
}
