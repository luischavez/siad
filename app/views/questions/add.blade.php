@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Agregar Pregunta
				@if ('open' === $type)
					abierta
				@endif
				@if ('choice' === $type)
					de seleccion
				@endif
				@if ('multiple' === $type)
					multiple
				@endif
			</h3>
		</div>
		<form role="form" class="form-horizontal" action="{{ route('question.create', $test->test_id) }}" method="POST">
		<div class="panel-body">
			<input type="hidden" name="type" value="{{ $type }}">
			@include('includes.field', array('name' => 'question_text', 'label' => 'Texto', 'type' => 'text'))
			@include('includes.field', array('name' => 'points', 'label' => 'Puntos', 'type' => 'number'))
			@if ('multiple' === $type)
				<p><b>Cada respuesta valdra los mismos puntos</b></p>
			@endif
			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Respuesta</th>
						<th>Es correcta</th>
						<th>
							<button type="button" class="btn btn-primary btn-xs" id="add-question">
								<span class="glyphicon glyphicon-plus"></span> Agregar
							</button>
						</th>
					</tr>
				</thead>
				<tbody id="answers">
					@if (($answerText = Input::old('answer_text')) && ($isCorrect = Input::old('is_correct')))
						@for ($i = 0; $i < count($answerText); $i++)
							<tr>
								<td>
									<input type="text" name="answer_text[]" value="{{ $answerText[$i] }}" class="form-control"/>
								</td>
								<td>
									@if (1 == $isCorrect[$i])
										<input type="checkbox" class="form-control checkable" checked/>
									@else
										<input type="checkbox" class="form-control checkable"/>
									@endif
									<input type="hidden" name="is_correct[]" value="{{ $isCorrect[$i] }}"/>
								</td>
								<td>
									<button type="button" class="btn btn-default btn-xs removable"><span class="glyphicon glyphicon-remove"></span> Eliminar</button>
								</td>
							</tr>
						@endfor
					@endif
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Terminar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('test.manager', $test->test_id) }}">Cancelar</a>
		</div>
		</form>
	</div>
@stop

@section('js')
	@parent
	<script>
		(function($) {
			$('#answers').on('click', '.removable', function() {
				$(this).closest('tr').remove();
			});
			$('#answers').on('click', '.checkable', function() {
				var val = $(this).next().val();

				val = 0 == val ? 1 : 0;

				$(this).next().val(val);
			});
			$('#add-question').bind('click', function(event) {
				$('#answers').append("<tr><td><input type=\"text\" name=\"answer_text[]\" class=\"form-control\"/></td><td><input type=\"checkbox\" class=\"form-control checkable\"/><input type=\"hidden\" name=\"is_correct[]\" value=\"0\"/></td><td><button type=\"button\" class=\"btn btn-default btn-xs removable\"><span class=\"glyphicon glyphicon-remove\"></span> Eliminar</button></td></tr>");
			});
		})(jQuery);
	</script>
@stop