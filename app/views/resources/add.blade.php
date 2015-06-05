@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Agregar
				@if ($type === 'video')
					Video <span class="glyphicon glyphicon-play"></span>
				@endif
				@if ($type === 'file')
					Archivo <span class="glyphicon glyphicon-file"></span>
				@endif
				@if ($type === 'url')
					enlace <span class="glyphicon glyphicon-link"></span>
				@endif
			</h3>
		</div>
		<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('resource.create', $course->course_id) }}" method="POST">
		<div class="panel-body">
			<input type="hidden" name="type" value="{{ $type }}">
			@include('includes.field', array('name' => 'title', 'label' => 'Titulo', 'type' => 'text'))
			@include('includes.field', array('name' => 'description', 'label' => 'Descripcion', 'type' => 'textarea'))
			@if ($type === 'video')
				@include('includes.field', array('name' => 'url', 'label' => 'Enlace de youtube', 'type' => 'text'))
			@endif
			@if ($type === 'file')
				@include('includes.field', array('name' => 'upload', 'label' => 'Archivo', 'type' => 'file'))
				<span>
					<b>Limite: 10mb</b>
				</span>
			@endif
			@if ($type === 'url')
				@include('includes.field', array('name' => 'url', 'label' => 'Enlace', 'type' => 'text'))
			@endif
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-lg btn-block">Agregar</button>
			<a class="btn btn-default btn-lg btn-block" href="{{ route('course.manager', $course->course_id) }}">Cancelar</a>
		</div>
		</form>
	</div>
@stop