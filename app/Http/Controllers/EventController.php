<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Uso Event:all para recuperar todos los registros de la tabla events y los guardo en la variable $events
        $events = Event::all(); 
        //Devuelvo la vista event.index, a la que le paso en forma de array esa información recuperada (los registros de la tabla events)
        //return view('event.index', compact('events'));
        //echo $json;
        $json = json_encode($events);
        var_dump($json);
        return view('event.index')->with('events',$events);
        //return response()->json($events);
        //return view('event.index');
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
        $request->validate(Event::$rules);//validamos la información

        $event = new Event($request->all());//Creamos la info con todos los datos
        $event->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    /**
     * Show events in fullcalendar
     *
     * @return \Illuminate\Http\Response
     */
    
    public function list()
    {
        $eventos = Event::all(); 
        $json = json_encode($eventos);
        return $json; //echo?
    }

}
