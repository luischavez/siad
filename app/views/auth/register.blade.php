@section('content')
	<form class="form-horizontal" role="form" action="{{ route('user.create') }}" method="POST">
		@include('includes.field', array('name' => 'first_name', 'label' => 'Nombre', 'type' => 'text'))
		@include('includes.field', array('name' => 'last_name', 'label' => 'Apellido', 'type' => 'text'))
		@include('includes.field', array('name' => 'email', 'label' => 'Correo', 'type' => 'email'))
		@include('includes.field', array('name' => 'user_name', 'label' => 'Nombre de usuario', 'type' => 'text'))
		@include('includes.field', array('name' => 'password', 'label' => 'Contraseña', 'type' => 'password'))
		@include('includes.field', array('name' => 'password_confirmation', 'label' => 'Confirmar contraseña', 'type' => 'password'))
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Registrar</button>
			</div>
		</div>
	</form>
@stop