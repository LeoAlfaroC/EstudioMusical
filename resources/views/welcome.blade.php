@extends('layouts.frontend')

@section('content')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h1 class="text-center">{{ config('app.name', 'Laravel') }}</h1>
		<p class="text-center">Concéntrate en tu música. Nosotros ponemos el lugar (y los instrumentos).</p>
		<p class="text-center">
			<a class="btn btn-primary btn-lg" href="{{ route('reserve') }}" role="button">Reserva una sala</a>
		</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Eventos</h1>
			@foreach($events as $event)
            <h2>{{ $event->room->room_number }}</h2>
            <p>Día: {{ \Carbon\Carbon::parse($event->day)->format('d/m/Y') }}</p>
            <p>Hora: {{ \Carbon\Carbon::parse($event->from_hour)->format('h:i A') }}</p>
            <p>Reservado por: {{ $event->user->name }}</p>
            @endforeach
		</div>
	</div>
	<hr>
	<footer>
		<p>&copy; 2017 Tekton Labs.</p>
	</footer>
</div>
@endsection