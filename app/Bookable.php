<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    // protected $table = custom_table_name
    // if commented, table name is bookables


    // this method is linked to booking model betweenDates() method and
    // to bookableAvailabilityController
    public function availableFor($from, $to): bool
    {
        // it returns true if 0 == count of objects that match for the selected dates.
        // in other world if there arent other bookings for the selected dates,
        // the count is 0.
        return $this->bookings()->betweenDates($from, $to)->count() === 0;
    }

    /**
     * Get price for given dates.
     *
     * @param  mixed $from
     * @param  mixed $to
     * @return array
     */
    public function priceFor($from, $to): array
    {
        $days = (new Carbon($from))->diffInDays(new Carbon($to)) + 1;
        $price = $days * $this->price;

        return [
            'total' => $price,
            'breakdown' => [
                $this->price => $days,
            ]
        ];
    }

    /* relations */

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
