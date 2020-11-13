<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Bookable;
use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        /* customer. sta per un oggetto:
         customer: {
            first_name: '',
            last_name: '',
            ...
        } */

        // .*. mi valida gli elementi interni a un array di oggetti

        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.street' => 'required|min:3',
            'customer.city' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip_code' => 'required|min:2',
        ]);


        // dopo aver validato tutti i campi devo controllare ancora una volta che ogni singola
        // booking sia available (magari ho lasciato aperto il carrello per 2 ore e nel frattempo
        // qualcun altro mi ha fregato). Per fare questo controllo, è meglio prima validare tutti
        // gli altri dati come sopra, e poi in un secondo step fare come qua sotto.
        // array_merge mi unisce tutti i dati validati.
        $data = array_merge($data, $request->validate([
            // custom validation function
            'bookings.*' => ['required', function ($attribute, $value, $fail) {
                // dd($attribute, $value);
                $bookable = Bookable::findOrFail($value['bookable_id']);
                if (!$bookable->availableFor($value['from'], $value['to'])) {
                    $fail('the object is not available in given dates');
                }
            }],

        ]));

        // dd($data);
        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];


        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];

            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking->price = $bookable->priceFor($bookingData['from'], $bookingData['to'])['total'];
            $booking->bookable_id = $bookingData['bookable_id'];

            // con associate() definisco bene le relazioni
            $booking->bookable()->associate($bookable);
            // ricorda: è un metodo perchè è una relazione
            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });
        return $bookings;
    }
}
