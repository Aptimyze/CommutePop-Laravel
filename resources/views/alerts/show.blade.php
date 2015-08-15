@extends('layouts.main')
@section('content')
	<h4>Sending to: {{{ $alert->email }}}</h4>
	<h4>Bus/Train number: {{{ $alert->route }}}</h4>
	<h4>Stop ID: {{{ $alert->stop }}}</h4>
	<h4>Desk departure time: {{{ $alert->departure_time }}}</h4>
	<h4>Time to get to stop: {{{ $alert->time_to_stop }}} minutes</h4>
	<h4>Alert to be sent: {{{ App\AlertHandler::describe($alert, true) }}}</h4>
		<ul class="no-bullet button-group">
			<li><a href="{!! route('alerts.edit', ['id' => $alert->id]) !!}"><button class="tiny success radius">Edit</button></a></li>
			<li>{!! Form::model($alert, ['route' => ['alerts.destroy', $alert->id], 'method' => 'DELETE']) !!}
				{!! Form::submit('Delete', ['class' => 'tiny alert button radius']) !!}
			{!! Form::close() !!}</li>
		</ul>
	<a href="{!! route('alerts.index') !!}" class="tiny radius button">back</a>
@stop