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
                <form action="{{route('event.store')}}" id="eventCreate"><!--event.create: nombre de la vista de routes-->
                    @csrf
                    <div class="form-group">
                      <label for="title">Título</label>
                      <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="Nombre del evento">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                    <div class="form-group">
                      <label for="start"></label>
                      <input type="text" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="Fecha de inicio">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                    <div class="form-group">
                      <label for="end"></label>
                      <input type="text" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="Fecha de finalización">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-target="#eventCreate" class="btn btn-success" id="btnCrear">Crear</button>
                <button type="button" class="btn btn-warning" id="btnModificar">Editar</button>
                <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var formulario = document.querySelector("#eventCreate");
    console.log(formulario);
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
          $("#title").val(info.event.title);
          $("#start").val(moment(info.event.start).format('YYYY-MM-DD'));
          $("#end").val(moment(info.event.end).format('YYYY-MM-DD'));

          $("#evento").modal("show");
      },


      events: "{{route('event.list')}}"
    });
    calendar.render();

    document.getElementById("btnCrear").addEventListener("click", fnSubmit);
    function fnSubmit(e){
    e.preventDefault();
    var target = this.dataset.target;
    var formulario = document.querySelector(target);

    var action = formulario.action;
    var datos = new FormData(formulario); //metemos todos los datos del formulario en un FormData
    console.log(datos);
    console.log("title: "+datos.get('title'));
    console.log("start: "+datos.get('start'));
    console.log("end: "+datos.get('end'));

    $.ajax({
      type: "POST",
      url: action,       
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