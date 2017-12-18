@extends('layouts.backend')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form class="form-horizontal" action="{{ route('save_client') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="client_id" value="{{ $client->id }}">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="name" placeholder="Nombre" value="{{ $client->name }}">
					</div>
					</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					<input type="email" class="form-control" name="email" placeholder="Email" value="{{ $client->email }}">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Teléfono</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="phone" placeholder="Telefono" value="{{ $client->phone }}">
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