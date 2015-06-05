@if ($errors->has($name))
	<div class="form-group has-error">
		{{ Form::label($name, $label, array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
			@if ('textarea' === $type)
				{{ Form::textarea($name, null, array('class' => 'form-control')) }}
			@else
				{{ Form::input($type, $name, null, array('class' => 'form-control')) }}
			@endif
			<span class="help-block alert alert-danger">{{ $errors->first($name) }}</span>
		</div>
	</div>
@else
	<div class="form-group">
		{{ Form::label($name, $label, array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
			@if ('textarea' === $type)
				{{ Form::textarea($name, null, array('class' => 'form-control')) }}
			@else
				{{ Form::input($type, $name, null, array('class' => 'form-control')) }}
			@endif
		</div>
	</div>
@endif
