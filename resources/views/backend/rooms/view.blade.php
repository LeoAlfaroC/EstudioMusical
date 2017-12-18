@extends('layouts.backend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="media">
				<div class="media-body">
					<h1 class="media-heading text-center">Sala {{ $room->room_number }}</h1>
					<br />
					<a href="#">
					<img class="media-object img-thumbnail" src="http://lorempixel.com/750/200" alt="Filler Image By LoremPixel.com">
					</a>
					<br />
					<p><strong>Fecha de registro:</strong> {{ \Carbon\Carbon::parse($room->created_at)->format('d/m/Y') }}</p>
					<p><strong>¿En uso?:</strong> Sí / No</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>Estadísticas</h2>
			<table class="table">
			<tbody>
			<tr>
				<td>Reservas totales: </td>
				<td>29 </td>
			</tr>
			<tr>
				<td>Reservas en los últimos 30 días: </td>
				<td>15 </td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>
@endsection