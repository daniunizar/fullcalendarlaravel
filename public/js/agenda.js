document.addEventListener('DOMContentLoaded', function() {
    var formulario = document.querySelector("#eventCreate");
    console.log(formulario);
    var calendarEl = document.getElementById('agenda');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale:"es",
      headerToolbar: {
        left: 'prev,next today myCustomButton',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      dateClick:function(info){
          $("#evento").modal("show");
      }
    });
    calendar.render();

    document.getElementById("btnCrear").addEventListener("click", fnSubmit);

  });


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
        //var calendar = $('#calendar');
        //calendar.refetchEvents();
        $("#evento").modal('hide');
      },
      error: function(error){console.log("Ha ocurido un error: "+error)},
      processData: false,  // tell jQuery not to process the data
      contentType: false   // tell jQuery not to set contentType
    });

}