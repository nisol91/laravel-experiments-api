<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Booking extends Model
{
    // this avoid to save non fillable fileds
    protected $fillable = ['from', 'to'];


    // this is a query scope, it do a query, it is linked to
    // bookable model
    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('from', '<=', $to)->where('to', '>=', $from);
    }


    // questo è un metodo che alla creazione del model(in questo caso bookings),
    // gli assegna direttamente uuid
    // in alternativa usa il concetto di OBSERVER.
    public static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            $booking->review_key = Str::uuid();
        });
    }

    // ricorda sempre: nel model c'è la business logic vera e propria.
    // il controller si limita a fare crud, query e a chiamare metodi del model

    // questo metodo mi fa una query per vedere se c'è corrispondenza fra
    // le review keys
    // ?Booking è il tipo di ritorno, cioè o un tipo Booking o null.
    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }

    /* relations */

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
