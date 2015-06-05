@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Editar curso: {{ $course->course_name }}</h3>
		</div>
		{{ Form::model($course, array('route' => array('course.update', $course->course_id))) }}
		<div class="panel-body">
			@include('includes.field', array('name' => 'course_name', 'label' => 'Nombre', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Descripcion', 'type' => 'textarea'))
			@include('includes.field', array('name' => 'password', 'label' => 'Contraseña', 'type' => 'password'))
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		{{ Form::close() }}
	</div>
@stop