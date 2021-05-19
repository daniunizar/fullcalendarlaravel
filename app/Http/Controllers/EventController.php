<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Uso Event:all para recuperar todos los registros de la tabla events y los guardo en la variable $events
        $events = Event::all();
        $users = User::all();

        foreach ($events as $e) {
            //$e->usr = $e->users;
            $e->users;
        }
        
        //Devuelvo la vista event.index, a la que le paso en forma de array esa información recuperada (los registros de la tabla events)
        //return view('event.index', compact('events'));
        //echo $json;
        //dump($events);
        $json = json_encode($events);
        
        //var_dump($json);
        //return view('event.index')->with('events',$events);
        return view('event.index', compact('events', 'users'));
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
  
        $event_id = $event->id;//Recuperamos la id del evento creado, para usarla en events_users
        $string_asistentes = $request->input('array_asistentes');
        $array_asistentes = explode(",", $string_asistentes);
        //var_dump($array_asistentes);
        $event=Event::find($event_id);

     
        $event->users()->attach($array_asistentes);
/*
        foreach ($array_asistentes as $valor){ //$valor es cada id de un checkbox activo, de un user que asiste al evento
            $event=Event::find($event_id);
            $event->users()->attach($valor);
        }
*/
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
      
        foreach ($eventos as $e) {
            $e->users;
        }
        return json_encode($eventos);
        
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
        //tras la actualización del evento, actualizamos events_users
        $string_asistentes = $request->input('array_asistentes');
        $array_asistentes = explode(",", $string_asistentes);
        //var_dump($array_asistentes);
        $event->users()->sync($array_asistentes);
    }

    public function destruir(Request $request)
    {
        $event = Event::find($request->id);    
        var_dump($event);  
        $event->delete();
        //return redirect('/');
    }

    public function pintar_asistentes(Request $request){
        $event_id = $request->id;
        $event = Event::find($event_id);
        $asistentes = $event->users;
        dump($asistentes);
        echo json_encode($asistentes);
    }

}
