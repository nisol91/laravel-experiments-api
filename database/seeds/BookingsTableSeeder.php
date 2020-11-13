<?php

use App\Bookable;
use App\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // per ogni bookable
        Bookable::all()->each(function (Bookable $bookable) {
            // creo la prima prenotazione "from, to" dalla factory, di modo che possa essere clonata
            // alla fine la factory definisce in che forma sono i from e to e mi da la possibilità di crearne 1,
            // che poi vado a clonare con i seed. I seed di fatto ciclano la factory.
            $booking = factory(Booking::class)->make();
            // creo una collection
            $bookings = collect([$booking]);

            // per un numero random (il numero di prenotazioni per quel bookable)
            for ($i = 0; $i < random_int(0, 20); $i++) {
                // from diventa il to iniziale piu qualche giorno random
                $from = clone ($booking->to)->addDays(random_int(0, 14));
                // to diventa il precedente from qui sopra piu qualche giorno random
                $to = clone ($from)->addDays(0, 14);


                // creo una nuova istanza dell oggetto e lo salvo direttamente con make
                // (è un alternativa a $booking = new Booking()...)
                // ricorda che i fields from e to devono essere fillable
                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to,
                    'price' => random_int(200, 5000),
                ]);

                // pusho la nuova istanza dell oggetto nella collection
                $bookings->push($booking);
            }
            // salvo la collection sfruttando la relation fra bookable e bookings
            // "i bookings di quel bookable sono salvati come collection nella variabile $bookings"
            $bookable->bookings()->saveMany($bookings);
        });
    }
}
