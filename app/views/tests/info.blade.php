@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				{{ $test->title }}
				@if ($test->hasQualification($user))
					<span class="glyphicon glyphicon-ok-circle"></span>
				@endif
			</h3>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>Descripción</dt>
				<dd>{{ $test->description }}</dd>
				<dt>Fecha de inicio</dt>
				<dd>{{ $test->start_date_format }}</dd>
				<dt>Fecha de cierre</dt>
				<dd>{{ $test->end_date_format }}</dd>
				<dt>Tiempo</dt>
				<dd>{{ $test->time }} Minutos</dd>
				<dt>Numero de preguntas</dt>
				<dd>{{ $test->questions->count() }}</dd>
			</dl>
			@if ($test->canStart($user))
				<p class="text-center">
					<a class="btn btn-lg btn-warning" href="{{ route('test.view', $test->test_id) }}">
						Comenzar examen
					</a>
				</p>
			@else
				@if ($test->isFinished($user))
					<table class="table table-striped table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th>Puntos</th>
								<th>Calificacion</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $test->userPoints($user) }}/{{ $test->totalPoints() }}</td>
								<td>{{ round($user->tests->find($test->test_id)->pivot->qualification, 2) }}</td>
							</tr>
						</tbody>
					</table>
				@endif
			@endif
		</div>
	</div>
@stop