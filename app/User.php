<?php

namespace App;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->hasMany(Shop::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function avatar()
    {
        return 'assets/images/faces-clipart/pic-1.png';
    }

    public function getIdAllowedShops(): array
    {
        $permissions = $this->permissions()->get();
        $ids = [];

        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $name = $permission->name;

                if (strpos($name, 'shops.') === false)
                    continue;

                $split_name = explode('.', $name);

                if (count($split_name) == 3) {
                    $ids[] = $split_name[2];
                } else if (count($split_name) == 2 && $split_name[1] == '*') {
                    $ids[] = '*';
                    break;
                }
            }
        }

        return $ids;
    }
}
