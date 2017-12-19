@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(session('reserve_saved'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Tu reserva se registró correctamente. Dentro de poco te llegará un correo con toda la información necesaria. ¡Gracias por usar nuestro servicio!
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Reserva actual</div>

                <div class="panel-body">
                    @if($reservation)
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object img-thumbnail" src="{{ asset('storage/rooms/' . $reservation->room->image_path) }}" alt="{{ $reservation->room->room_number }}" style="max-height: 200px;">
                        </div>
                        <div class="media-body">
                            <h2 class="media-heading text-primary">Sala {{ $reservation->room->room_number }}</h2>
                            <h4><strong>Día:</strong> {{ \Carbon\Carbon::parse($reservation->day)->format('d/m/Y') }}</h4>
                            <h4><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reservation->from_hour)->format('h:i A') }}</h4>
                            <h4><strong>Duracion:</strong> {{ floor($reservation->duration) }}:{{ str_pad(round(($reservation->duration - floor($reservation->duration)) * 60), 2, '0', STR_PAD_LEFT) }} horas</h4>
                        </div>
                    </div>
                    @else
                    <p class="text-center">No tienes reservas actualmente :(</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h2>Reservas pasadas</h2>
        <table class="table">
            <thead>
                <th>Sala</th>
                <th>Día</th>
                <th>Hora</th>
                <th>Duración</th>
            </thead>
            <tbody>
            @foreach($past_reservations as $reserve)
                <tr>
                    <td>{{ $reserve->room->room_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserve->day)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserve->from_hour)->format('h:i A') }}</tdh4>
                    <td>{{ floor($reserve->duration) }}:{{ str_pad(round(($reserve->duration - floor($reserve->duration)) * 60), 2, '0', STR_PAD_LEFT) }} horas</td>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
