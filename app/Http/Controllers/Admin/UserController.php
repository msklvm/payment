<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::with('roles')->get();

        return view('pages.admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permissions::getShops()->get();

        return view('pages.admin.user.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $this->validatorCreate($input);

        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if (!$user) {
            alert()->error('Error added user');
            return redirect()->back();
        }

        $user->roles()->detach();
        $user->roles()->attach($input['roles']);

        $user->permissions()->detach();
        $user->permissions()->attach($input['permissions']);

        alert()->success('User success added');

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permissions::getShops()->get();

        $item = Permissions::select(['id'])->where('name', 'shops.*')->first();
        $permissions->prepend(['pid' => $item->id, 'title' => 'Все']);

        return view('pages.admin.user.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $input = $request->all();

        if ($user->email == $input['email']) {
            unset($input['email']);
        }

        $validator = $this->validation($input);

        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        $result = $user->update($input);

        $user->roles()->detach();
        $user->roles()->attach($input['roles']);

        $user->permissions()->detach();
        $user->permissions()->attach($input['permissions']);

        if ($result) {
            alert()->success('User updated');
        } else {
            alert('error updating');
        }


        return redirect()->back();
    }

    public function password(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            alert()->error($validator->errors()->first());
            return redirect()->back();
        }

        $user->password = Hash::make($input['password']);
        $user->save();

        alert()->success('Password updated');

        return redirect()->back();
    }

    public function delete(User $user)
    {
    }

    private function validation(array $input)
    {
        return Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
