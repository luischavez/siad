@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Editar
				@if ($resource->type === 'video')
					Video <span class="glyphicon glyphicon-play"></span>
				@endif
				@if ($resource->type === 'file')
					Archivo <span class="glyphicon glyphicon-file"></span>
				@endif
				@if ($resource->type === 'url')
					Enlace <span class="glyphicon glyphicon-link"></span>
				@endif
			</h3>
		</div>
		{{ Form::model($resource, array('route' => array('resource.update', $resource->resource_id), 'files' => true)) }}
		<div class="panel-body">
			@include('includes.field', array('name' => 'title', 'label' => 'Titulo', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Descripcion', 'type' => 'textarea'))
			@if ($resource->type === 'video')
				@include('includes.field', array('name' => 'attached', 'label' => 'Enlace de youtube', 'type' => 'text'))
			@endif
			@if ($resource->type === 'file')
				@include('includes.field', array('name' => 'upload', 'label' => 'Archivo', 'type' => 'file'))
				<p>Limite: 10mb</p>
				<p>{{ $resource->attached }}</p>
			@endif
			@if ($resource->type === 'url')
				@include('includes.field', array('name' => 'attached', 'label' => 'Enlace', 'type' => 'text'))
			@endif
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		{{ Form::close() }}
	</div>
@stop