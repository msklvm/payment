<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $roles = Role::all();
        return view('pages.admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $data = [
            'name' => $input['name'],
        ];

        $validator = $this->validation($data);
        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        $result = Role::create($data);

        if ($result) {
            alert()->success('Role updated');
            return redirect()->route('role.index');
        }

        alert('error updating');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('pages.admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->all();

        $validator = $this->validation($input);

        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        $result = $role->update($input);

        if ($result) {
            alert()->success('Role updated');
            return redirect()->route('role.index');
        }

        alert('error updating');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Role $role)
    {
        if (!$role->delete())
            alert()->error('Ошибка удаления');

        alert()->success('Удалено');

        return redirect(route('role.index'));
    }

    private function validation(array $input)
    {
        return Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);
    }
}
