@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">Calificaciones</h1>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>Profesor</dt>
				<dd>{{ $course->teacher->full_name }}</dd>
				<dt>Curso</dt>
				<dd>{{ $course->course_name }}</dd>
				<dt>Descripción</dt>
				<dd>{{ $course->description }}</dd>
			</dl>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Examen</th>
							<th>Fecha</th>
							<th>Calificación</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($course->tests as $test)
							@if ($test->hasQualification($user) || $test->isFinalized())
								<tr>
									<td>{{ $test->title }}</td>
									<td>
										<p><b>Inicio</b> {{ $test->start_date_format }}</p>
										<p><b>Fin</b> {{ $test->end_date_format }}</p>
									</td>
									<td>
										@if ($test->students->contains($user->user_id))
											{{ round($test->students->find($user->user_id)->pivot->qualification, 2) }}
										@else
											0
										@endif
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer">
		</div>
	</div>
@stop