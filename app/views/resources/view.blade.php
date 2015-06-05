@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">{{ $resource->title }}</h3>
		</div>
		<div class="panel-body">
			<p class="lead text-muted">{{ $resource->description }}</p>
			@if ($resource->is('file'))
				@if ($resource->toFile->is_pdf)
					<embed src="{{ URL::to('uploads/resources/' . $resource->resource_id) }}" class="col-xs-12" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
				@endif
				<div class="text-center">
					<a class="btn btn-primary btn-lg" href="{{ route('resource.download', $resource->resource_id) }}">Descargar</a>
				</div>
			@endif
			@if ($resource->is('video'))
				<iframe type="text/html" class="col-xs-12" height="385" src="http://www.youtube.com/embed/{{ $resource->toVideo->video_id }}" frameborder="0">
				</iframe>
			@endif
			@if ($resource->is('url'))
				<div class="text-center">
					<a class="btn btn-primary btn-lg" href="{{ $resource->toUrl->url }}">Ir</a>
				</div>
			@endif
		</div>
	</div>
@stop