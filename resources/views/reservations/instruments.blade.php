@extends('layouts.frontend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
		 @if(session('reserve_saved'))
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			Tu reserva se registró correctamente. A continuación, elige los instrumentos que necesitarás.
		</div>
		@endif
		<h1>Intrumentos disponibles</h1>
			@if(count($instruments) == 0)
				No hay intrumentos disponibles :(
			@else
			<form action="{{ route('reserve_save_instruments') }}" method="POST" id="form_instuments">
			{{ csrf_field() }}
			</form>
			<table class="table">
			<tbody>
				<thead>
					<th>Descripción</th>
					<th>Disponibilidad</th>
					<th>Reservar</th>
				</thead>
				@foreach($categories as $category)
				<tr>
					<td colspan="3">
						<h4>{{ $category->name }}</h4>
					</td>
				</tr>

				@foreach($instruments as $instrument)
				@if($instrument->id == $category->id)
				<tr>
					<td>
						{{ $instrument->description }}
					</td>
					<td>
						{{ $instrument->stock }} unidades
					</td>
					<td>
						<input type="checkbox" name="instruments[]" value="{{ $instrument->instrument_id }}" form="form_instuments" />			

						<label for="duration">Cantidad:</label>
						<input type="number" id="duration" name="quantity_{{ $instrument->instrument_id }}" value="1" step="1" min="1" max="{{ $instrument->stock }}" form="form_instuments">

					</td>
				</tr>
				@endif
				@endforeach
				@endforeach
			</tbody>
			</table>
			<button form="form_instuments" type="submit" class="btn btn-primary">Reservar instrumentos</button>
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