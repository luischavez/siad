@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">Perfil</h1>
		</div>
		<div class="panel-body">
			<div class="media">
				<div class="pull-left">
					<img class="media-object" src="{{ $user->avatar }}">
				</div>
				<div class="media-body">
					<dl class="dl-horizontal">
						<dt>Nombre:</dt>
						<dd>{{ $user->first_name }}</dd>
						<dt>Apellido:</dt>
						<dd>{{ $user->last_name }}</dd>
						<dt>Nombre de usuario:</dt>
						<dd>{{ $user->user_name }}</dd>
						<dt>Correo:</dt>
						<dd>{{ $user->email }}</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			@if (Auth::user() === $user)
				<a type="button" class="btn btn-primary" href="{{ route('profile.edit') }}">Editar</a>
			@endif
		</div>
	</div>
@stop