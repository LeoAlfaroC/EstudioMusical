@extends('layouts.frontend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="alert alert-info">
				Nuestros estudios están disponibles desde las {{ env('OPENING_TIME') }} hasta las {{ env('CLOSING_TIME') }} horas.
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form method="GET" ACTION="{{ route('reserve_search') }}">
				<div class="form-group">
					<label for="day">¿Qué día?</label>
					<input type="date" class="form-control" id="day" name="day" required>
				</div>
				<div class="form-group">
					<label for="hour">¿A qué hora?</label>
					<input type="time" class="form-control" id="hour" name="hour" step="1800" required>
				</div>
				<button type="submit" class="btn btn-primary">Buscar salas disponibles</button>
			</form>
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