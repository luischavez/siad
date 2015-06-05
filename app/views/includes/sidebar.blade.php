<ul class="nav nav-pills nav-stacked">
	@foreach ($links as $link)
		@if (!isset($link['route']))
			<li><a href="#">{{ $link['name'] }}</a></li>
		@else
			@if (is_array($link['route']))
				@if (in_array(Route::currentRouteName(), $link['route']))
					<li class="active" ><a href="{{ route($link['route'][0]) }}">{{ $link['name'] }}</a></li>
				@else
					<li><a href="{{ route($link['route'][0]) }}">{{ $link['name'] }}</a></li>
				@endif
			@else
				@if (strcasecmp(Route::currentRouteName(), $link['route']) == 0)
					<li class="active"><a href="{{ route($link['route']) }}">{{ $link['name'] }}</a></li>
				@else
					<li><a href="{{ route($link['route']) }}">{{ $link['name'] }}</a></li>
				@endif
			@endif
		@endif
	@endforeach
</ul>