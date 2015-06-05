@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">
				Calificaciones del examen: {{ $test->title }}
			</h1>
		</div>
		<table class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Alumno</th>
					<th>Calificación</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($course->students as $student)
					<tr>
						<td>{{ $student->full_name }}</td>
						<td>
							@if ($student->tests->contains($test->test_id))
								{{ $student->tests->find($test->test_id)->pivot->qualification }}
							@else
								0
							@endif
						</td>
						
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-footer">
			<a class="btn btn-primary btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Regresar</a>
		</div>
	</div>
@stop