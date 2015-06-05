@section('content')
	<div class="jumbotron">
		<h1 class="text-center">¡Bienvenido a SIAD!</h1>
		<p>
			<a class="tip" href="#" data-toggle="tooltip" title="" data-original-title="Sistema Interactivo de Aprendizaje a Distancia">SIAD</a>
			es el sistema de Aprendizaje a distancia creado por y para la comunidad de estudiantes de la <a class="tip" href="http://uach.mx" target="_blank" data-toggle="tooltip" title="" data-original-title="Universidad Autonoma de Chihuahua">UACH</a>.
		</p>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Ultimos 10 cursos</h3>
		</div>
		<table class="table table-striped table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th>Curso</th>
					<th>Profesor</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($courses as $course)
					<tr>
						<td>
							{{ $course->course_name }}
						</td>
						<td><b>{{ $course->teacher->full_name }}</b>
							({{ $course->teacher->email }})</td>
						<td>
							<a class="btn btn-primary btn-xs" href="{{ route('course.register', $course->course_id) }}">
								@if ($course->password)
									<span class="glyphicon glyphicon-lock"></span>
								@endif
								Matricularme
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@stop