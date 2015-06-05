@section('content')
	<div class="jumbotron">
		<div class="text-center">
			<p>¿Ya eres parte de SIAD?</p>
			<p>
				<a class="btn btn-primary btn-lg btn-block" href="{{ route('login') }}">
					Inícia sesión
				</a>
			</p>
			<p>¿Quieres ser parte de SIAD?</p>
			<p>
				<a class="btn btn-primary btn-lg btn-block" href="{{ route('register') }}">
					Registrate
				</a>
			</p>
		</div>
		<blockquote align="right">
			<small>SIAD</small>
		</blockquote>
	</div>
@stop