@extends('layouts.backend')

@section('content')
<div class="container">
	@if(session('saved'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		Tus cambios se guardaron correctamente.
	</div>
	@endif
	<h1>Salas</h1>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Número</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@if($rooms->isEmpty())
			<tr>
				<td colspan=3>
					<p class="text-center">¡No hay salas para mostrar!</p>
				</td>
			</tr>
			@else

			@foreach($rooms as $room)
			<tr>
				<th scope="row">{{ $loop->iteration }}</th>
				<td>{{ $room->room_number }}</td>
				<td>
					<a href="{{ route('view_room', [$room->id]) }}">Ver</a> |
					<a href="{{ route('edit_room', [$room->id]) }}">Editar</a>
				</td>
			</tr>
			@endforeach

			@endif
		</tbody>
	</table>
</div>
@endsection