<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    // LE PERMISSIONS NON LE UTILIZZO PER ORA, UTILIZZO SOLO LA RELAZIONE USER-ROLE


    // relations

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
