@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Preguntas: {{ $test->questions->count() }}
				<span class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-pencil"></span>
							Agregar <span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="{{ route('question.add', array($test->test_id, 'open')) }}">
									<span class="glyphicon glyphicon-pencil"></span>
									Abierta
								</a>
							</li>
							<li>
								<a href="{{ route('question.add', array($test->test_id, 'choice')) }}">
									<span class="glyphicon glyphicon-check"></span>
									Seleccion
								</a>
							</li>
							<li>
								<a href="{{ route('question.add', array($test->test_id, 'multiple')) }}">
									<span class="glyphicon glyphicon-th-list"></span>
									Multiple
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
					<th>Pregunta</th>
					<th>Tipo</th>
					<th>Puntos</th>
					<th>Respuestas</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($test->questions as $question)
					<tr>
						<td>{{ $question->question_text }}</td>
						<td>
							@if ('open' === $question->type)
								Abierta
							@endif
							@if ('choice' === $question->type)
								Seleccion
							@endif
							@if ('multiple' === $question->type)
								Multiple
							@endif
						</td>
						<td>{{ $question->points }}</td>
						<td>
							@foreach ($question->answers as $answer)
								<p>
									{{ $answer->answer_text }}
									@if ($answer->is_correct)
										<span class="glyphicon glyphicon-check"></span>
									@endif
								</p>
							@endforeach
						</td>
						<td>
							<a class="btn btn-primary btn-xs" href="{{ route('question.edit', array($test->test_id, $question->question_id)) }}">
								<span class="glyphicon glyphicon-edit"></span> Editar
							</a>
							<a class="btn btn-danger btn-xs confirm" href="{{ route('question.delete', array($test->test_id, $question->question_id)) }}">
								<span class="glyphicon glyphicon-remove"></span> Eliminar
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-body"></div>
		<div class="panel-footer">
			<a class="btn btn-primary btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Finalizar</a>
		</div>
	</div>
@stop