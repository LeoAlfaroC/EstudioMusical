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
	<h1>Clientes</h1>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@if($clients->isEmpty())
			<tr>
				<td colspan=3>
					<p class="text-center">¡No hay clientes para mostrar!</p>
				</td>
			</tr>
			@else

			@foreach($clients as $client)
			<tr>
				<th scope="row">{{ $loop->iteration }}</th>
				<td>{{ $client->name }}</td>
				<td>
					<a href="{{ route('view_client', [$client->id]) }}">Ver</a> |
					<a href="{{ route('edit_client', [$client->id]) }}">Editar</a>
				</td>
			</tr>
			@endforeach

			@endif
		</tbody>
	</table>
</div>
@endsection