@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">Cursos</h1>
		</div>
		<div class="panel-body">
			<h2>Cursos que imparto</h2>
			<a class="btn btn-primary" href="{{ route('course.add') }}">Crear curso</a>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nombre del curso</th>
							<th>Estudiantes</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($teacherCourses as $course)
							<tr>
								<td>
									{{ $course->course_name }}
									@if (!$course->started_at)
										<span class="label label-info">Aún no inicia</span>
									@endif
								</td>
								<td>{{ $course->students->count() }}</td>
								<td>
									<a class="btn btn-primary btn-xs" href="{{ route('course.manager', $course->course_id) }}">
										<span class="glyphicon glyphicon-eye-open"></span> Ver
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<h2>Cursos en los que estoy inscrito</h2>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nombre del curso</th>
							<th>Nombre del maestro</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($studentCourses as $course)
							<tr>
								<td>
									{{ $course->course_name }}
									@if (!$course->started_at)
										<span class="label label-info">Aún no inicia</span>
									@endif
								</td>
								<td>{{ $course->teacher->full_name }}</td>
								<td>
									<a class="btn btn-primary btn-xs" href="{{ route('course.view', $course->course_id) }}">
										<span class="glyphicon glyphicon-eye-open"></span> Ver
									</a>
									<a class="btn btn-info btn-xs" href="{{ route('course.qualifications', $course->course_id) }}">
										<span class="glyphicon glyphicon-list-alt"></span> Calificaciones
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer">
		</div>
	</div>
@stop