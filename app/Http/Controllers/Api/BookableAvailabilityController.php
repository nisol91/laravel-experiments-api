<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // di fatto questo metodo gestisce il form di inserimento date
    public function __invoke($id, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);
        $bookable = Bookable::findOrFail($id);

        // it refers to availableFor method in the bookable model
        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([])
            : response()->json([], 404);

        // è la versione elegante del piu semplice e comprensibile:
        // semplicemente conto il numero di risultati di una query

        /* $queryCount = Booking::where('bookable_id', $id)->where('from', '<=', $data['to'])->where('to', '>=', $data['from'])->count();
        if ($queryCount === 0) {
            return response()->json([]);
        } else {
            return response()->json([], 404);
        } */

        // in ogni caso ritorno un responso vuoto se è available, se no un 404.
        // in maniera ancora più semplice, ma meno linguaggio server, avrei potuto mandare true-false
    }
}
