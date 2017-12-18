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
	<h1>Instrumentos</h1>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Descripción</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@if($instruments->isEmpty())
			<tr>
				<td colspan=3>
					<p class="text-center">¡No hay instrumentos para mostrar!</p>
				</td>
			</tr>
			@else

			@foreach($instruments as $instrument)
			<tr>
				<th scope="row">{{ $loop->iteration }}</th>
				<td>{{ $instrument->description }}</td>
				<td>
					<a href="{{ route('view_instrument', [$instrument->id]) }}">Ver</a> |
					<a href="{{ route('edit_instrument', [$instrument->id]) }}">Editar</a>
				</td>
			</tr>
			@endforeach

			@endif
		</tbody>
	</table>
</div>
@endsection