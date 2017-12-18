@extends('layouts.frontend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
		<h1>Salas disponibles</h1>
			@if($rooms->isEmpty())
				No hay salas disponibles :(
			@else
			<table class="table">
			<tbody>
				<thead>
					<th>N° de Sala</th>
					<th>Disponibilidad</th>
					<th>Acción</th>
				</thead>
				@foreach($rooms as $room)
				<tr>
					<td>
						{{ $room->room_number }}
					</td>
					<td>
						{{ \Carbon\Carbon::parse($room->available_hours)->format('G:i') }} horas
					</td>
					<td>
						<form method="POST" action="{{ route('reserve_save') }}" class="form-inline">
						{{ csrf_field() }}
						<input type="hidden" name="room_id" value="{{ $room->id }}">
						<div class="form-group">
						<label for="duration">Duración:</label>
						<input type="number" class="form-control" id="duration" name="duration" value="0" step="0.5" min="0" max="{{ $room->available_hours_int }}">
						</div>
						<button class="btn btn-primary">Reservar</form>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>
			@endif
		</div>
	</div>
</div>
@endsection

@section('custom_js')
	<script>
		Date.prototype.toDateInputValue = (function() {
			var local = new Date(this);
			local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
			return local.toJSON().slice(0,10);
		});
		document.getElementById('day').value = new Date().toDateInputValue();
		document.getElementById('day').setAttribute("min", new Date().toDateInputValue());
	</script>
@endsection