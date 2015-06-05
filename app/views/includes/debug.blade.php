@if (Config::get('app.debug', false))
	<div class="list-group">
		@foreach (DB::getQueryLog() as $log)
			<a href="#" class="list-group-item">
				<h4 class="list-group-item-heading"><b>Query:</b> {{ $log['query'] }}</h4>
				<p class="list-group-item-text">
					<b>Bindings:</b>
					{@foreach ($log['bindings'] as $binding)
						{{ $binding }}
					@endforeach}
				</p>
				<b>Time: <small>{{ $log['time'] }} s</small></b>
			</a>
		@endforeach
	</div>
@endif