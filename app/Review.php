<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = ['id', 'content', 'rating'];


    // this 2 function because reviews have unique string id and not numeric id
    public function getIncrementing()
    {
        return false;
    }
    public function getKeyType()
    {
        return 'string';
    }

    /* relations */

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
