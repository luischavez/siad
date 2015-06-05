<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'SIAD')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	@section('css')
		{{ HTML::style('css/bootstrap.min.css') }}
		{{ HTML::style('css/simplePagination.css') }}
	@show
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-12">
						<nav class="navbar navbar-default" role="navigation">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#user-navbar">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand" href="#">SIAD <small>Sistema Interactivo de Aprendizaje a Distancia</small></a>
							</div>
							<div class="collapse navbar-collapse" id="user-navbar">
								<!-- Menu -->
							</div>
						</nav>
					</div>
				</div>
				<div class="media page-header">
					<div class="pull-left">
						<img class="media-object" src="{{ $user->avatar }}">
					</div>
					<div class="media-body">
						<h2 class="media-heading">{{ $user->first_name . ' ' . $user->last_name }}</h2>
						<a type="button" class="btn btn-warning btn-xs" href="{{ route('do.logout') }}">Salir</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3">
				@section('sidebar')
					@include('includes.sidebar')
				@show
			</div>
			<div class="col-xs-9">
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
		{{ HTML::script('js/jquery.simplePagination.js') }}
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
		<script type="text/javascript">
			$('.tip').tooltip();
		</script>
	@show
</body>
</html>