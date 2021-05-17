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
    public function destroy(Request $request)
    {
        $event = Event::find($request->id);      
        $event->delete();
    }

    /**
     * Show events in fullcalendar
     *
     * @return \Illuminate\Http\Response
     */
    
    public function list()
    {
        $eventos = Event::all(); 

        //$json = json_encode($eventos);
        //return $json; //echo?
        //return response()->json($eventos);
        //Recuperamos la array de registros de la tabla events, la mapeamos, guardamos en $events y la retornamos como json
   
        $events = array();
        foreach ($eventos as $valor){
            $aux['id']=$valor['id'];
            $aux['title']=$valor['title'];
            $aux['start']=$valor['start'];
            $aux['end']=$valor['end'];
            array_push($events,$aux);   
        }
        return json_encode($events);
        
    }

    /**
     * Update event in database
     *
     * @return \Illuminate\Http\Response
     */
    
    public function actualizar(Request $request)
    {
        //echo "Has llamado a la función actualizar";
        //var_dump($request);
        $event = Event::find($request->id);
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        //$event->save();
        $event->update();
        //return $event;
    }

    public function destruir(Request $request)
    {
        $event = Event::find($request->id);    
        var_dump($event);  
        $event->delete();
        //return redirect('/');
    }


}
