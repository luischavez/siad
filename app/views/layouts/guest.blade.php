<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'SIAD')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	@section('css')
		{{ HTML::style('css/bootstrap.min.css') }}
	@show
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>SIAD</h1>
					<h2><small>Sistema Interactivo de Aprendizaje a Distancia</small></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				@foreach (Session::get('messages', array()) as $message)
					<div class="alert alert-{{ $message['type'] }}">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ $message['text'] }}
					</div>
					{{ Session::forget('messages') }}
				@endforeach
				@yield('content')
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				@include('includes.debug')
			</div>
		</div>
	</div>
	@section('js')
		{{ HTML::script('js/jquery.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/holder.js') }}
		{{ HTML::script('js/bootbox.min.js') }}
		<script>
			(function($) {
				$(document).on("click", ".confirm", function(e) {
					e.preventDefault();
					
					var location = $(this).attr('href');

					bootbox.confirm("¿Esta seguro?", function(confirm) {
						if (confirm) {
							window.location.replace(location);
						}
					});
				});
			})(jQuery);
		</script>
	@show
</body>
</html>