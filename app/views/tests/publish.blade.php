@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Publicar examen: {{ $test->title }}</h3>
		</div>
		<form role="form" class="form-horizontal" action="{{ route('test.do.publish', array($course->course_id, $test->test_id)) }}" method="POST">
		<div class="panel-body">
			@include('includes.field', array('name' => 'start_date', 'label' => 'Fecha de inicio', 'type' => 'text'))
			@include('includes.field', array('name' => 'end_date', 'label' => 'Fecha de cierre', 'type' => 'text'))
			@include('includes.field', array('name' => 'time', 'label' => 'Tiempo en minutos', 'type' => 'number'))
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Publicar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		</form>
	</div>
@stop

@section('css')
	@parent
	{{ HTML::style('css/jquery.simple-dtpicker.css') }}
@stop

@section('js')
	@parent
	{{ HTML::script('js/jquery.simple-dtpicker.js') }}
	<script>
		(function($) {
			$('*[name=start_date]').appendDtpicker({"inline": true});
			$('*[name=end_date]').appendDtpicker({"inline": true});
		})(jQuery);
	</script>
@stop