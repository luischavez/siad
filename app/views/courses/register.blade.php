@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">{{ $course->course_name }}</h1>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>Profesor</dt>
				<dd>{{ $course->teacher->full_name }}</dd>
				<dt>Curso</dt>
				<dd>{{ $course->course_name }}</dd>
				<dt>Descripción</dt>
				<dd>{{ $course->description }}</dd>
			</dl>
			<form class="form form-inline" action="{{ route('course.subscribe', $course->course_id) }}" method="POST">
				@if ($course->password)
					@if ($errors->has('password'))
						<div class="form-group col-xs-8 has-error">
							<div class="input-group input-group-sm">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span>
								</span>
								<input type="password" class="form-control" name="password" placeholder="Contraseña">
							</div>
							<span class="help-block alert alert-danger">
								{{ $errors->first('password') }}
							</span>
						</div>
					@else
						<div class="form-group col-xs-8">
							<div class="input-group input-group-sm">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span>
								</span>
								<input type="password" class="form-control" name="password" placeholder="Contraseña">
							</div>
						</div>
					@endif
					<button type="submit" class="btn btn-primary btn-sm">Unirme</button>
				@else
					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-sm">Unirme</button>
					</div>
				@endif
			</form>
		</div>
	</div>
@stop