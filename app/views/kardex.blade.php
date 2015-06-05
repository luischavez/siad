@section('content')
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title">Kardex</h1>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>Nombre:</dt>
				<dd>{{ $user->first_name }}</dd>
				<dt>Apellido:</dt>
				<dd>{{ $user->last_name }}</dd>
				<dt>Nombre de usuario:</dt>
				<dd>{{ $user->user_name }}</dd>
				<dt>Correo:</dt>
				<dd>{{ $user->email }}</dd>
			</dl>
			<table class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Nombre del curso</th>
						<th>Estado</th>
						<th>Calificación</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($user->kardex as $kardex)
						<tr>
							<td>{{ $kardex->course_name }}</td>
							<td>{{ $kardex->status }}</td>
							<td>{{ $kardex->qualification }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
		</div>
	</div>
@stop