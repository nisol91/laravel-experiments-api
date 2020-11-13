<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WineEvent;
use Illuminate\Http\Request;

class WineEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $events = WineEvent::all()->toArray();
        // $events = WineEvent::paginate(5);
        // dd($events);

        return $events;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data = $request->validate([
            'event.name' => 'required|min:2',
            'event.description' => 'required|min:2',
            'event.city' => 'required|min:2',
            'event.price' => 'required|min:1',
            'event.from' => 'required',
            'event.to' => 'required',
            'event.coords.lat' => 'required',
            'event.coords.lng' => 'required',
        ]);

        // dd($data);


        // cosi e piu flessibile
        $event = new WineEvent();
        $event->name = $data['event']['name'];
        $event->description = $data['event']['description'];
        $event->city = $data['event']['city'];
        $event->price = $data['event']['price'];
        $event->lat = $data['event']['coords']['lat'];
        $event->lng = $data['event']['coords']['lng'];

        $event->save();

        // così è piu sicuro e salva solo i campi fillable nel model
        // $event = WineEvent::create($data['event']);

        return $event;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
