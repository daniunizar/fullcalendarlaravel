<?php

namespace App\Http\Controllers;

use App\Models\Events_users;
use Illuminate\Http\Request;

class EventsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events_users  $events_users
     * @return \Illuminate\Http\Response
     */
    public function show(Events_users $events_users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events_users  $events_users
     * @return \Illuminate\Http\Response
     */
    public function edit(Events_users $events_users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events_users  $events_users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Events_users $events_users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events_users  $events_users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Events_users $events_users)
    {
        //
    }

    public function listar_asistentes(Request $request){
        $event_id = $request->id;//ID del evento del que quiero los asistentes
        $events = Events_users::where('event_id','=', $event_id); //recupero todos los registros de la tabla events_users en la que la id del evento es igual a $event_id
        $array_ids_asistentes = array(); //Genero una array en la que voy a guardar las ids de los asistentes
        foreach ($events as $valor){//Recorro la array con todos los registros de eventos y extraigo de ella la id de cada asistente para meterla en la array auxiliar y de ella a la array_ids_asistentes
            $id_asistente=$valor['user_id'];
            array_push($array_ids_asistentes ,$aux);   
        }
        dump($array_ids_asistentes);
        return json_encode($array_ids_asistentes);
    }
}
