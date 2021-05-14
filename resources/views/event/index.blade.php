@extends('layouts.app')
@section('content')
<div class="container">
    <div id="agenda">
    </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#evento">
  Launch
</button>

<!-- Modal -->
<div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{route('event.store')}}" id="event_form">
                    <input type="text" id="id">
                    @csrf
                    <div class="form-group">
                      <label for="title">Título</label>
                      <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="Nombre del evento">
                    </div>
                    <div class="form-group">
                      <label for="start">Fecha de inicio</label>
                      <input type="text" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="Fecha de inicio">
                    </div>
                    <div class="form-group">
                      <label for="end">Fecha de finalización</label>
                      <input type="text" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="Fecha de finalización">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-target="#event_form" class="btn btn-success" id="btnCrear">Crear</button>
                <button type="button" data-target="#event_form" class="btn btn-warning" id="btnModificar">Editar</button>
                <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
  //CONFIGURACIÓN DEL FULL CALENDAR
  document.addEventListener('DOMContentLoaded', function() {
    var formulario = document.querySelector("#event_form");
    //console.log(formulario);
    var calendarEl = document.getElementById('agenda');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale:"es",
      selectable: true,//Permite seleccionar los días del calendario
            editable: true,
            height: 850,//Altura del calendario
      headerToolbar: {
        left: 'prev,next today myCustomButton',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      dateClick:function(info){
          $("#evento").modal("show");
      },
      eventClick:function(info){
        console.log(info);
          $("#id").val(info.event.id);
          $("#title").val(info.event.title);
          $("#start").val(moment(info.event.start).format('YYYY-MM-DD'));
          $("#end").val(moment(info.event.end).format('YYYY-MM-DD'));
          $("#evento").modal("show");
      },
      events: "{{route('event.list')}}"
    });
    calendar.render();
    //Listener de todos los botones
    document.getElementById("btnCrear").addEventListener("click", fnSubmit);
    document.getElementById("btnModificar").addEventListener("click", updateEvent);
    
    //Al pulsar el Btn Crear Evento de la Modal evento
    function fnSubmit(e){
        e.preventDefault();
        var target = this.dataset.target;
        var formulario = document.querySelector(target);

        //var action = formulario.action;
        console.log(formulario);
        var datos = new FormData(formulario); //metemos todos los datos del formulario en un FormData
        console.log(datos);
        console.log("title: "+datos.get('title'));
        console.log("start: "+datos.get('start'));
        console.log("end: "+datos.get('end'));

        $.ajax({
          type: "POST",
          url: "{{route('event.store')}}",       
          data: datos,
          success: function(){
            calendar.refetchEvents();
            $("#evento").modal('hide');
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });

    }
    //AL pulsar el Btn Editar de la Modal evento
    function updateEvent(e){
        e.preventDefault();
        var title = $('#title').val();
        var target = this.dataset.target;
        var formulario = document.querySelector(target);
        var datos = new FormData(formulario); //metemos todos los datos del formulario en un FormData
        
        //le fuerzo la inclusión de la id en el data form con un append
        var id = $('#id').val();
        console.log("LA ID DEL EVENTO ES: "+id);
        datos.append('id', id);

        //debugueo por consola
        console.log(datos);
        console.log("id: "+datos.get('id'));
        console.log("title: "+datos.get('title'));
        console.log("start: "+datos.get('start'));
        console.log("end: "+datos.get('end'));

        $.ajax({
          type: "POST",
          url: "{{route('event.actualizar')}}",       
          data: datos,
          success: function(){
            calendar.refetchEvents();
            $("#evento").modal('hide');
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });

    }
  });



</script>


@if ($events->isEmpty())
                <div>No hay Eventos</div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Start</th>
                            <th>End</th>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{!! $event->id !!}</td>
                                <td>{!! $event->title !!}</td>
                                <td>{!! $event->start !!}</td>
                                <td>{!! $event->end !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
@endsection