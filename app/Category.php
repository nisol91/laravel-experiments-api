<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // relations

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_categories');
    }
}
