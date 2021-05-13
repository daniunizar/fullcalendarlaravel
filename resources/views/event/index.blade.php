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
@endsection