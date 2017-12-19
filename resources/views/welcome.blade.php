@extends('layouts.frontend')

@section('custom_css')
<style>
	.main-text {
		position: absolute;
		top: 150px;
		width: 96.66666666666666%;
		color: #FFF;
		text-shadow: 1px 1px #000;
		font-size: 120px!important;
	}

	.btn-min-block {
		min-width: 170px;
		line-height: 26px;
	}

	.btn-clear {
		color: #FFF;
		border-color: #FFF;
		border-width: 2px;
		margin-right: 15px;
	}

	.btn-clear:hover {
		background-color: #6699CC;
	}

	.arrowalign {
		top: 50%;
	}

	.arrowalign:hover {
		vertical-align: middle;
	}

	.carousel-control {
		color: #fff;
		top: 50%;
		bottom: auto;
		padding-top: 0px;
		width: 30px;
		height: 30px;
		text-shadow: none;
		opacity: 0.9;
	}

	.side-crop {
		max-height: 500px;
		overflow: hidden;
	}

	.side-crop img {
		max-height: initial;
	}
</style>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="carousel-example" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carousel-example" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example" data-slide-to="1"></li>
					<li data-target="#carousel-example" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
                    @php
                        $banner_num = rand(1, 8);
                    @endphp
					<div class="item active">
						<div class="side-crop">
							<img src="{{ asset('storage/banners/banner' . $banner_num++ . '.jpg') }}" alt="First slide" />
						</div>
						<div class="carousel-caption">
						</div>
					</div>
					<div class="item">
						<div class="side-crop">
							<img src="{{ asset('storage/banners/banner' . $banner_num++ . '.jpg') }}" alt="First slide" />
						</div>
						<div class="carousel-caption">
						</div>
					</div>
					<div class="item">
						<div class="side-crop">
							<img src="{{ asset('storage/banners/banner' . $banner_num . '.jpg') }}" alt="First slide" />
						</div>
						<div class="carousel-caption">
						</div>
					</div>
				</div>

			</div>
			<div class="main-text">
				<div class="col-md-12 text-center">
					<h1>Studio Manager</h1>
					<h3>Concéntrate en tu música. Nosotros ponemos el lugar (y los instrumentos).
					</h3>
					<a class="btn btn-primary btn-lg btn-clear btn-min-block" href="{{ route('reserve') }}" role="button">Reserva una sala</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" id="events">
	<div class="row">
		<div class="col-md-12">

		</div>
	</div>
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

@section('custom_js')
<script>
$('a[href*="#inicio"]').on('click',function (e) {
    e.preventDefault();

    $("html, body").animate({ scrollTop: 0 }, "slow");
});

$('a[href*="#eventos"]').on('click',function (e) {
    e.preventDefault();

    $("html, body").animate({ scrollTop: document.getElementById('events').offsetTop }, "slow");
});
</script>
@endsection