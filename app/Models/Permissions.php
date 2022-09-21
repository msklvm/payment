<?php


namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class Permissions extends Permission
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function shops()
    {
        return $this->morphTo();
    }

    public function scopeGetShops($query)
    {
        $pattern = 'REGEXP_REPLACE(NAME, \'shops\..($|\.)\', "")';

        return $query
            ->selectRaw('permissions.id as pid, permissions.name as pname, shops.*')
            ->join((new Shop)->getTable() . ' as shops', 'shops.id','=', DB::raw($pattern))
            ->where('permissions.name','like','shops%');
    }

}
