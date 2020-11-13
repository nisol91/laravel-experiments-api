<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    // relations
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // questa helper function mi ritorna il corretto path interno per caricare le foto nel frontend
    // in pratica mi crea un path dell'oggetto album che posso prendere cosi: asset($settings->path)
    // è utile quando si hanno sia path url che path storage
    public function getPathAttribute()
    {
        $url = $this->profile_image;
        if (stristr($url, 'http') == false) {
            $url = 'storage/' . $this->profile_image;
        }
        return $url;
    }
}
