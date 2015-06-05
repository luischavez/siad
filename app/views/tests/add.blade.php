@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Agregar examen</h3>
		</div>
		<form role="form" class="form-horizontal" action="{{ route('test.create', $course->course_id) }}" method="POST">
		<div class="panel-body">
			@include('includes.field', array('name' => 'title', 'label' => 'Titulo', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Descripcion', 'type' => 'textarea'))
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Agregar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		</form>
	</div>
@stop