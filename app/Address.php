<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // è il contrario di fillable. indica quali NON possono essere fillate
    protected $guarded = ['id'];
}
