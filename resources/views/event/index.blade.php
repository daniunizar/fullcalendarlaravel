@extends('layouts.app')
@section('content')
<div id="snackbar"><p id="texto_tostada"></p></div>
<div class="container">
    <div id="agenda">
    </div>
</div>
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
                      <label for="date_start">Fecha de inicio</label>
                      <input type="date" class="form-control" name="date_start" id="date_start" aria-describedby="helpId" placeholder="Fecha de inicio">
                    </div>
                    <div class="form-group">
                      <label for="hour_start">Horade inicio</label>
                      <input type="time" class="form-control" name="hour_start" id="hour_start" aria-describedby="helpId" placeholder="Hora de inicio">
                    </div>
                    <div class="form-group">
                      <label for="date_end">Fecha de finalización</label>
                      <input type="date" class="form-control" name="date_end" id="date_end" aria-describedby="helpId" placeholder="Fecha de finalización">
                    </div>
                    <div class="form-group">
                      <label for="hour_end">Hora de finalización</label>
                      <input type="time" class="form-control" name="hour_end" id="hour_end" aria-describedby="helpId" placeholder="Hora de inicio">
                    </div>
                    <div class="form-group">
                      <table>
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Asiste</th>
                          </tr>
                        </thead>
                        <tbody id="tbody_asistentes">
                          @foreach ($users as $user)                            
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td><input type="checkbox" id="<?php $id = $user->id; echo $id;?>"></td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-target="#event_form" class="btn btn-success" id="btnCrear">Crear</button>
                <button type="button" data-target="#event_form" class="btn btn-warning" id="btnModificar">Editar</button>
                <button type="button" data-target="#event_form" class="btn btn-danger" id="btnEliminar">Eliminar</button>
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
        limpiarFormulario();
        $("#btnCrear").show();
        $("#btnModificar").hide();
        $("#btnEliminar").hide();
        $("#title").val("Nuevo Evento");
        $('#date_start').val(moment(info.date).format('YYYY-MM-DD'));
        $('#hour_start').val('10:00:00');
        $('#date_end').val(moment(info.date).format('YYYY-MM-DD'));
        $('#hour_end').val('12:00:00');
        $("#evento").modal("show");
      },
      eventClick:function(info){
        limpiarFormulario();
        console.log(info);
          $("#id").val(info.event.id);
          $("#title").val(info.event.title);
          $("#date_start").val(moment(info.event.start).format('YYYY-MM-DD'));
          $("#hour_start").val(moment(info.event.start).format('hh:mm:ss'));
          $("#date_end").val(moment(info.event.end).format('YYYY-MM-DD'));
          $("#hour_end").val(moment(info.event.end).format('H:mm:ss'));
          $("#btnCrear").hide();
           $("#btnModificar").show();
          $("#btnEliminar").show();
          $("#evento").modal("show");
//          var array_asistentes = info.event.extendedProps.users[0];
          var array_asistentes = info.event.extendedProps.users;
          var array_id_asistentes = new Array();
          //array_asistentes.forEach(asistente => console.log(asistente['id']));
          array_asistentes.forEach(asistente => array_id_asistentes.push(asistente['id']));
          console.log("Intento de mostrar asistentes: "+array_asistentes);
          console.log("intento mostrar array de ids:");
          console.log(array_id_asistentes);

          //info.event.setExtendedProp( name, value )


          pintar_asistentes(array_id_asistentes);
      },
      eventDrop: function(info) {
        actualizar_elemento_dropeado(info);
      },
      eventResize: function(info) {
              actualizar_elemento_dropeado(info);
            },
      events: "{{route('event.list')}}"
    });
    calendar.render();
    //Listener de todos los botones
    document.getElementById("btnCrear").addEventListener("click", fnSubmit);
    document.getElementById("btnModificar").addEventListener("click", updateEvent);
    document.getElementById("btnEliminar").addEventListener("click", deleteEvent);
    
    //Al pulsar el Btn Crear Evento de la Modal evento
    function fnSubmit(e){
        e.preventDefault();
        var target = this.dataset.target;
        var formulario = document.querySelector(target);

        //var action = formulario.action;
        console.log(formulario);
        var date_start = $('#date_start').val();
        var hour_start = $('#hour_start').val();
        var start = date_start + " "+hour_start;
        var date_end = $('#date_end').val();
        var hour_end = $('#hour_end').val();
        var end = date_end + " "+hour_end;
        var datos = new FormData(formulario); //metemos todos los datos del formulario en un FormData
        datos.append('start', start);
        datos.append('end', end);
        console.log(datos);
        console.log("title: "+datos.get('title'));
        console.log("start: "+datos.get('start'));
        console.log("end: "+datos.get('end'));

        //Generamos lista de asistentes a partir de los checkbox marcados:
        var array_asistentes = new Array();

        $("input:checkbox:checked").each(function() {
             console.log($(this).attr('id'));
             array_asistentes.push($(this).attr('id'));
        });
        datos.append('array_asistentes', array_asistentes);

        $.ajax({
          type: "POST",
          url: "{{route('event.store')}}",       
          data: datos,
          success: function(){
            calendar.refetchEvents();
            $("#evento").modal('hide');
            mostrar_snackbar("crear");
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });

    }
    //AL pulsar el Btn Editar de la Modal evento
    function updateEvent(e){
        e.preventDefault();
        var r = confirm("¿Desea guardar los cambios?");
        if (r == false) {
          $("#evento").modal('hide');
        } else {
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
        var date_start = $('#date_start').val();
        var hour_start = $('#hour_start').val();
        var start = date_start + " "+hour_start;
        var date_end = $('#date_end').val();
        var hour_end = $('#hour_end').val();
        var end = date_end + " "+hour_end;
        datos.append('start', start);
        datos.append('end', end);
        console.log(datos);
        console.log("date_start: "+datos.get('date_start'));
        console.log("date_end: "+datos.get('date_end'));
        console.log("hour_start: "+datos.get('hour_start'));
        console.log("hour_end: "+datos.get('hour_end'));
        console.log("start: "+datos.get('start'));
        console.log("end: "+datos.get('end'));
        var array_asistentes = new Array();
        $("input:checkbox:checked").each(function() {
             console.log($(this).attr('id'));
             array_asistentes.push($(this).attr('id'));
        });
        datos.append('array_asistentes', array_asistentes);
        console.log("Array asistentes: "+array_asistentes);
        $.ajax({
          type: "POST",
          url: "{{route('event.actualizar')}}",       
          data: datos,
          success: function(){
            calendar.refetchEvents();
            $("#evento").modal('hide');
            mostrar_snackbar("modificar");
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });
        }
    }

    function deleteEvent(){
      var r = confirm("¿Desea eliminar el evento seleccionado?");
        if (r == false) {
          $("#evento").modal('hide');
        } else {
      var id = $("#id").val();
      console.log("Id del elemento a borrar: "+id);
      var data = new FormData();
      data.append('id', id);
      console.log(data);
      console.log("llego aquí");
      $.ajax({
          type: "POST",
          url: "{{route('event.destruir')}}",   
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },   
          data: data,
          success: function(){
            calendar.refetchEvents();
            $("#evento").modal('hide');
            mostrar_snackbar("eliminar");
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });
      }
    }
    function actualizar_elemento_dropeado(info){
      var id = info.event.id;
      var title = info.event.title;
      var start = moment(info.event.start).format('YYYY-MM-DD H:mm:ss');
      var end = moment(info.event.end).format('YYYY-MM-DD H:mm:ss');
      console.log("llego aqui1");
      var data = new FormData(); //metemos todos los datos del formulario en un FormData
      data.append('id', id);
      data.append('title', title);
      data.append('start', start);
      data.append('end', end);
      console.log("llego aqui2");
      console.log("ID para actualizar: "+data.get('id'));
      console.log("title para actualizar: "+data.get('title'));
      console.log("start para actualizar: "+data.get('start'));
      console.log("end para actualizar: "+data.get('end'));
      $.ajax({
          type: "POST",
          url: "{{route('event.actualizar')}}",    
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },     
          data: data,
          success: function(){
            calendar.refetchEvents();
          },
          error: function(error){console.log("Ha ocurido un error: "+error)},
          processData: false,  // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        });
    }

    function pintar_asistentes(array_ids_asistentes){
      console.log(typeof array_ids_asistentes);
      //var array_ids_asistentes = string_ids_asistentes.split(",");
      $("input:checkbox").each(function() {
              console.log("Comprobamos si se incluye la id: "+$(this).attr('id'));
              for(var i=0; i<array_ids_asistentes.length; i++){
                if($(this).attr('id')==array_ids_asistentes[i]){
                  $(this).prop("checked", true);
                }
              }
        });
    }

    function limpiarFormulario(){
          $("#id").val("");
          $("#title").val("");
          $("#date_start").val("");
          $("#hour_start").val("");
          $("#date_end").val("");
          $("#hour_end").val("");
          //limpiamos todos los checkboxes:
          $("input:checkbox:checked").each(function() {
             console.log($(this).attr('id'));
             $(this).prop("checked", false);
        });
    }
  });

  function mostrar_snackbar(tipo_accion) {
  // Get the snackbar DIV  
  var snackbar = document.getElementById("snackbar");
  console.log(snackbar);
  if(snackbar.classList.contains("verde")){
    snackbar.classList.remove("verde");
  }
  if(snackbar.classList.contains("rojo")){
    snackbar.classList.remove("rojo");
  }
  if(snackbar.classList.contains("naranja")){
    snackbar.classList.remove("naranja");
  }

  var texto_crear = "Evento creado";
  var texto_modificar = "Evento modificado con éxito";
  var texto_eliminar = "Evento eliminado";
  var texto = "Se han guardado los cambios";
  switch (tipo_accion){
    case "crear":
      snackbar.classList.add("verde");
      texto= texto_crear;
      break;
    case "modificar":
      snackbar.classList.add("naranja");
      texto= texto_modificar;
    break;
    case "eliminar":
      snackbar.classList.add("rojo");
      texto = texto_eliminar;
    break;
  }
  console.log(snackbar);
  $('#texto_tostada').text(texto);
  // Add the "show" class to DIV
  snackbar.classList.toggle("show");

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}


</script>

<!--
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
-->
@endsection


