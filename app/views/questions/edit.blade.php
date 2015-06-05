@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Editar Pregunta
				@if ('open' === $question->type)
					abierta
				@endif
				@if ('choice' === $question->type)
					de seleccion
				@endif
				@if ('multiple' === $question->type)
					multiple
				@endif
			</h3>
		</div>
		{{ Form::model($question, array('route' => array('question.update', $test->test_id, $question->question_id))) }}
		<div class="panel-body">
			@include('includes.field', array('name' => 'question_text', 'label' => 'Texto', 'type' => 'text'))
			@include('includes.field', array('name' => 'points', 'label' => 'Puntos', 'type' => 'number'))
			@if ('multiple' === $question->type)
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
					@foreach ($question->answers as $answer)
						<tr>
							<td>
								<input type="text" name="answer_text[]" value="{{ $answer->answer_text }}" class="form-control"/>
							</td>
							<td>
								@if ($answer->is_correct)
									<input type="checkbox" class="form-control checkable" checked/>
									<input type="hidden" name="is_correct[]" value="1"/>
								@else
									<input type="checkbox" class="form-control checkable"/>
									<input type="hidden" name="is_correct[]" value="0"/>
								@endif
							</td>
							<td>
								<button type="button" class="btn btn-default btn-xs removable"><span class="glyphicon glyphicon-remove"></span> Eliminar</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('test.manager', $test->test_id) }}">Cancelar</a>
		</div>
		{{ Form::close() }}
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