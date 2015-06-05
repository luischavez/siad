@section('content')
	{{ Form::model($user, array('route' => 'profile.update', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h1 class="panel-title">Editar Perfil</h1>
			</div>
			<div class="panel-body">
				@include('includes.field', array('name' => 'first_name', 'label' => 'Nombre', 'type' => 'text'))
				@include('includes.field', array('name' => 'last_name', 'label' => 'Apellido', 'type' => 'text'))
				@include('includes.field', array('name' => 'email', 'label' => 'Correo', 'type' => 'email'))
				@include('includes.field', array('name' => 'new_password', 'label' => 'Nueva contraseña', 'type' => 'password'))
				@include('includes.field', array('name' => 'new_password_confirmation', 'label' => 'Confirmar contraseña', 'type' => 'password'))
				@include('includes.field', array('name' => 'password', 'label' => 'Contraseña actual', 'type' => 'password'))
			</div>
			<div class="panel-footer">
				<button type="submit" class="btn btn-warning">Guardar</button>
				<a type="button" class="btn btn-default" href="{{ route('profile.view') }}">Cancelar</a>
			</div>
		</div>
	{{ Form::close() }}
@stop