@section('content')
	<h1 class="text-center">{{ $course->course_name }}</h1>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Información
				<span class="pull-right">
					@if (!$course->started_at)
						<a class="btn btn-default btn-xs" href="{{ route('course.edit', $course->course_id) }}">
							<span class="glyphicon glyphicon-edit"></span>
							Editar
						</a>
					@endif
				</span>
			</h3>
		</div>
		<div class="panel-body">
			@if ($course->started_at)
				@if (0 === $course->students->count())
					<div class="alert alert-info">
						Todos los estudiantes se dieron de baja
					</div>
				@endif
			@else
				<p class="lead">
					<small class="text-muted text-primary">
						Comparte este enlace para permitir la entrada al curso
					</small>
					<input type="text" class="form-control" value="{{ route('course.register', $course->course_id) }}">
					@if ($course->description)
						<p><b>Descripcion:</b> {{ $course->description }}</p>
					@endif
					@if ($course->password)
						<p><b>Contraseña:</b> {{ $course->password }}</p>
					@endif
				</p>
				@if (0 === $course->students->count())
					<p class="text-info">Actualmente el curso no tiene estudiantes, necesitas tener por lo menos un estudiante para comenzar el curso</p>
				@endif
			@endif
			@if (0 < $course->students->count())
				<p>
					<button type="button" class="btn btn-primary btn-xs" data-toggle="collapse" data-target="#students">
						<span class="glyphicon glyphicon-user"></span>
						<b>Estudiantes:</b> {{ $course->students->count() }}
					</button>
				</p>
				<div id="students" class="table-responsive collapse">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th>Nombre del estudiante</th>
								<th>Correo</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($course->students as $student)
								<tr>
									<td>{{ $student->full_name }}</td>
									<td>{{ $student->email }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
			<div class="text-center">
				@if (!$course->started_at && 0 < $course->students->count())
					<a class="btn btn-primary btn-lg btn-block confirm tip" href="{{ route('course.start', $course->course_id) }}" data-toggle="tooltip" title="" data-original-title="Una vez iniciado el curso no se podran inscribir mas estudiantes">
						Iniciar curso
					</a>
				@endif
				@if ($course->started_at && !$course->closed_at)
					<a class="btn btn-primary btn-lg btn-block confirm tip" href="{{ route('course.close', $course->course_id) }}" data-toggle="tooltip" title="" data-original-title="Al finalizar el curso se calificaran a los estudiantes, posteriormente podras reabrir el curso">
						Finalizar curso
					</a>
				@endif
				<a class="btn btn-default btn-lg btn-block confirm tip" href="{{ route('course.cancel', $course->course_id) }}" data-toggle="tooltip" title="" data-original-title="Esto eliminara totalmente el curso del sistema">
					Cancelar curso
				</a>
			</div>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Examenes
				<span class="pull-right">
					<a class="btn btn-default btn-xs" href="{{ route('test.add', $course->course_id) }}">
						<span class="glyphicon glyphicon-pencil"></span>
						Agregar
					</a>
				</span>
			</h3>
		</div>
		<table class="table table-striped table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($course->tests as $test)
					<tr>
						<td>{{ $test->title }}</td>
						<td>
							@if ($test->isPublished())
								Publicado
								<p><b>Inicio:</b> {{ $test->start_date_format }}</p>
								<p><b>Cierre:</b> {{ $test->end_date_format }}</p>
							@endif
							@if ($test->isEditable())
								Editable
							@endif
							@if ($test->isFinalized())
								Finalizado
							@endif
						</td>
						<td>
							@if ($test->isEditable())
								<a class="btn btn-primary btn-xs" href="{{ route('test.edit', $test->test_id) }}">
									<span class="glyphicon glyphicon-edit"></span> Editar
								</a>
								<a class="btn btn-primary btn-xs" href="{{ route('test.manager', $test->test_id) }}">
									<span class="glyphicon glyphicon-edit"></span> Administrar
								</a>
								@if ($test->hasQuestions() && $course->started_at)
									<a class="btn btn-primary btn-xs" href="{{ route('test.publish', array($course->course_id, $test->test_id)) }}">
										<span class="glyphicon glyphicon-send"></span> Publicar
									</a>
								@endif
								<a class="btn btn-danger btn-xs confirm" href="{{ route('test.delete', $test->test_id) }}">
									<span class="glyphicon glyphicon-remove"></span> Eliminar
								</a>
							@endif
							@if ($test->isFinalized())
								<a class="btn btn-default btn-xs" href="{{ route('test.qualifications', $test->test_id) }}">
									<span class="glyphicon glyphicon-list-alt"></span> Calificaciones
								</a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-footer">
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Recursos
				<span class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span>
							Agregar <span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="{{ route('resource.add', array($course->course_id, 'video')) }}">
									<span class="glyphicon glyphicon-play"></span>
									Video
								</a>
							</li>
							<li>
								<a href="{{ route('resource.add', array($course->course_id, 'file')) }}">
									<span class="glyphicon glyphicon-file"></span>
									Archivo
								</a>
							</li>
							<li>
								<a href="{{ route('resource.add', array($course->course_id, 'url')) }}">
									<span class="glyphicon glyphicon-link"></span>
									Enlace
								</a>
							</li>
						</ul>
					</div>
				</span>
			</h3>
		</div>
		<table class="table table-striped table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Tipo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($course->resources as $resource)
					<tr>
						<td>{{ $resource->title }}</td>
						<td>
							@if ($resource->type === 'video')
								<span class="glyphicon glyphicon-play"></span>
								Video
							@endif
							@if ($resource->type === 'file')
								<span class="glyphicon glyphicon-file"></span> Archivo
							@endif
							@if ($resource->type === 'url')
								<span class="glyphicon glyphicon-link"></span> Enlace
							@endif
						</td>
						<td>
							<a class="btn btn-primary btn-xs" href="{{ route('resource.edit', $resource->resource_id) }}">
								<span class="glyphicon glyphicon-edit"></span> Editar
							</a>
							<a class="btn btn-default btn-xs" href="{{ route('resource.view', $resource->resource_id) }}">
								<span class="glyphicon glyphicon-eye-open"></span> Ver
							</a>
							<a class="btn btn-danger btn-xs confirm" href="{{ route('resource.delete', $resource->resource_id) }}">
								<span class="glyphicon glyphicon-remove"></span> Eliminar
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-footer">
		</div>
	</div>
@stop