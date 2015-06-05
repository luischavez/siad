@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Nuevo curso</h3>
		</div>
		<form role="form" class="form-horizontal" action="{{ route('course.create') }}" method="POST">
		<div class="panel-body">
			@include('includes.field', array('name' => 'course_name', 'label' => 'Nombre', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Descripcion', 'type' => 'textarea'))
			@include('includes.field', array('name' => 'password', 'label' => 'Contraseña', 'type' => 'password'))
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Crear</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.lists') }}">Cancelar</a>
		</div>
		</form>
	</div>
@stop