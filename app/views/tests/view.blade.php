@section('content')
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div id="counter"></div>
			<div class="desc">
				<div>Horas</div>
				<div>Minutos</div>
				<div>Segundos</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<form role="form" class="form form-horizontal" action="{{ route('test.submit', $test->test_id) }}" method="POST">
		<div class="panel-body">
			@foreach ($test->questions as $key => $question)
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div id="item-{{ $key }}" class="item">
						<label>{{ $key + 1 }}.- {{ $question->question_text }}</label>
						@foreach ($question->answers as $answer)
							@if ($question->is('open'))
								<div class="input-group input-group-sm">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-pencil"></span>
									</span>
									<input type="text" name="question{{ $question->question_id }}" value="{{ $user->getAnswer($question) }}" class="form-control">
								</div>
							@endif
							@if ($question->is('choice'))
								<div class="input-group input-group-sm">
									<span class="input-group-addon">
										@if ($user->hasAnswer($question, $answer->answer_text))
											<input type="radio" name="question{{ $question->question_id }}" value="{{ $answer->answer_text }}" checked>
										@else
											<input type="radio" name="question{{ $question->question_id }}" value="{{ $answer->answer_text }}">
										@endif
									</span>
									<b class="form-control">{{ $answer->answer_text }}</b>
								</div>
							@endif
							@if ($question->is('multiple'))
								<div class="input-group input-group-sm">
									<span class="input-group-addon">
										@if ($user->hasAnswer($question, $answer->answer_text))
											<input type="checkbox" name="question{{ $question->question_id }}[]" value="{{ $answer->answer_text }}" checked>
										@else
											<input type="checkbox" name="question{{ $question->question_id }}[]" value="{{ $answer->answer_text }}">
										@endif
									</span>
									<b class="form-control">{{ $answer->answer_text }}</b>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-xs-4-col col-xs-offset-4">
					<div id="paginator"></div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-lg btn-block" name="save" value="1">Guardar sin enviar</button>
			<button type="submit" class="btn btn-default btn-lg btn-block">Enviar</button>
		</div>
		</form>
	</div>
@stop

@section('css')
	@parent
	<style type="text/css">
		.cntSeparator {
			font-size: 54px;
			margin: 10px 7px;
			color: #000;
		}
		.desc div {
			float: left;
			font-family: Arial;
			width: 70px;
			margin-right: 65px;
			font-size: 13px;
			font-weight: bold;
			color: #000;
		}
	</style>
@stop

@section('js')
	@parent
	{{ HTML::script('js/jquery.countdown.min.js') }}
	<script>
		(function($) {
			$('#counter').countdown({
				stepTime: 1,
				startTime: "{{ $time }}",
				timerEnd: function() {
					window.location.replace('{{ route('test.info', $test->test_id) }}');
				},
				image: "{{ URL::to('img/digits.png') }}"
			});

			var itemsOnPage = 5;

			$('#paginator').pagination({
				prevText: 'Anterior',
				nextText: 'Siguiente',
				items: {{ $test->questions->count() }},
				itemsOnPage: itemsOnPage,
				cssStyle: 'light-theme',
				onInit: function() {
					var pages = $('#paginator').pagination('getPagesCount');

					if (1 == pages) {
						$('#paginator').pagination('disable');
						$('#paginator').hide();
					} else {
						$('.item').hide();

						var current = $('#paginator').pagination('getCurrentPage');
						var first = (current - 1) * itemsOnPage;
						var end = current * itemsOnPage;

						for (var i = first; i < end; i++) {
							$('#item-' + i).show();
						}
					}
				},
				onPageClick: function(page, event) {
					event.preventDefault();

					$('.item').hide();

					var current = $('#paginator').pagination('getCurrentPage');
					var first = (current - 1) * itemsOnPage;
					var end = current * itemsOnPage;

					for (var i = first; i < end; i++) {
						$('#item-' + i).show();
					}
				}
			});
		})(jQuery);
	</script>
@stop