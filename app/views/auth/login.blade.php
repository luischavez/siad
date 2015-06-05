@section('content')
	<form class="form-horizontal" role="form" action="{{ route('do.login') }}" method="POST">
		@include('includes.field', array('name' => 'user_name', 'label' => 'Nombre de usuario', 'type' => 'text'))
		@include('includes.field', array('name' => 'password', 'label' => 'Contraseña', 'type' => 'password'))
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember"> Recordarme?
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Iníciar sesión</button>
			</div>
		</div>
	</form>
@stop