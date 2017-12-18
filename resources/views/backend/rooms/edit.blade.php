@extends('layouts.backend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form class="form-horizontal" action="{{ route('save_room') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="room_id" value="{{ $room->id }}">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Número de sala</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="room_number" placeholder="Nombre" value="{{ $room->room_number }}">
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