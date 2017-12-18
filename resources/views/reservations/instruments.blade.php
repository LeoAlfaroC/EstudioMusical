@extends('layouts.frontend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
		 @if(session('reserve_saved'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			Tu reserva se registró correctamente.
		</div>
		@endif
		<h1>Intrumentos disponibles</h1>
			@if($intruments->isEmpty())
				No hay intrumentos disponibles :(
			@else
			<form action="{{ route('reserve_save_instruments') }}" method="POST" id="form_instuments">
			{{ csrf_field() }}
			</form>
			<table class="table">
			<tbody>
				<thead>
					<th>ID</th>
					<th>Descripción</th>
					<th>Reservar</th>
				</thead>
				@foreach($intruments as $instrument)
				<tr>
					<td>
						{{ $instrument->id }}
					</td>
					<td>
						{{ $instrument->description }}
					</td>
					<td>
						<input type="checkbox" name="instruments[]" value="{{ $instrument->id }}" form="form_instuments" />					
					</td>
				</tr>
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