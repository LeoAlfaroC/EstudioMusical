@extends('layouts.backend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form class="form-horizontal" action="{{ route('save_instrument') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="instrument_id" value="{{ $instrument->id }}">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="description" placeholder="Nombre" value="{{ $instrument->description }}">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection