@extends('layouts.backend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="media">
				<div class="media-left">
					<a href="#">
					<img class="media-object img-thumbnail" src="http://lorempixel.com/200/200" alt="Filler Image By LoremPixel.com">
					</a>
				</div>
				<div class="media-body">
					<h1 class="media-heading">{{ $room->name }}</h1>
					<br />
					
					<p><strong>Email:</strong> {{ $room->email }}</p>
					<p><strong>Teléfono:</strong> {{ $room->phone }}</p>
					<p><strong>Miembro desde:</strong> {{ \Carbon\Carbon::parse($room->created_at)->format('d/m/Y') }}</p>
					<p><strong>Reserva actual:</strong> 20/12/2017 - 20:00 / Ninguna</p>
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
			<tr>
				<td>Reservas totales: </td>
				<td>29 </td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>
@endsection