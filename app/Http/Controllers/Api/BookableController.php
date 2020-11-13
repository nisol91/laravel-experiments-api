<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;
use Debugbar;

class BookableController extends Controller
{
    public function index()
    {
        // utilizzo di debugbar
        Debugbar::info(Bookable::all()->toArray());
        Debugbar::warning('messaggio di warning da nicola');

        // altro debugging
        // dd('ooo');
        // dd(Bookable::all());
        // return Bookable::all();



        // il metodo è sempre questo: definisco una risorsa che mi espone solo i campi che mi servono
        // poi la ritorno passandole la query che voglio [in questo caso Bookable::all()]
        return BookableIndexResource::collection(
            Bookable::all()
        );
    }
    public function show($id)
    {
        // return Bookable::findOrFail($id);
        return new BookableShowResource(Bookable::findOrFail($id));
    }
}
