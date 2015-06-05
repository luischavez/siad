@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Editar examen</h3>
		</div>
		{{ Form::model($test, array('route' => array('test.update', $test->test_id))) }}
		<div class="panel-body">
			@include('includes.field', array('name' => 'title', 'label' => 'Titulo', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Decripcion', 'type' => 'textarea'))
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		{{ Form::close() }}
	</div>
@stop