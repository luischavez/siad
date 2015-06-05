@section('content')
	<div class="text-center">
		<h1>
			{{ $course->course_name }}
			<a class="btn btn-warning btn-xs confirm" href="{{ route('course.unsubscribe', $course->course_id) }}">Dar de baja</a>
		</h1>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Examenes</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
			@foreach ($course->tests as $test)
				@if ($test->isPublished())
					<a href="{{ route('test.info', $test->test_id) }}" class="list-group-item">
						<h4 class="list-group-item-heading">
							{{ $test->title }}
							@if ($test->hasQualification($user))
								<span class="glyphicon glyphicon-ok-circle"></span>
							@endif
						</h4>
						<p class="list-group-item-text">{{ $test->description }}</p>
					</a>
				@endif
			@endforeach
			</div>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Recursos</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
			@foreach ($course->resources as $resource)
				@if ($resource->is('url'))
					<a href="{{ $resource->toUrl->url }}" target="_blank" class="list-group-item">
						<h4 class="list-group-item-heading">
							{{ $resource->title }}
							<span class="glyphicon glyphicon-link"></span>
						</h4>
						<p class="list-group-item-text">{{ $resource->description }}</p>
					</a>
				@endif
				@if ($resource->is('file'))
					<a href="{{ route('resource.view', $resource->resource_id) }}" target="_blank" class="list-group-item">
						<h4 class="list-group-item-heading">
							{{ $resource->title }}
							@if ($resource->toFile->is_pdf)
								<span class="glyphicon glyphicon-file"></span>
							@else
								<span class="glyphicon glyphicon-download"></span>
							@endif
						</h4>
						<p class="list-group-item-text">{{ $resource->description }}</p>
					</a>
				@endif
				@if ($resource->is('video'))
					<a href="{{ route('resource.view', $resource->resource_id) }}" target="_blank" class="list-group-item">
						<h4 class="list-group-item-heading">
							{{ $resource->title }}
							<span class="glyphicon glyphicon-play"></span>
						</h4>
						<p class="list-group-item-text">{{ $resource->description }}</p>
					</a>
				@endif
			@endforeach
			</div>
		</div>
	</div>
@stop