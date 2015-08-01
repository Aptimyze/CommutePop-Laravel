@extends('layouts.main')
@section('content')
	<h2>All Alert Recipients</h2>
	@foreach($alerts as $alert)
	<h3>Alert {{{ $alert->id }}}:</h3>
		<ul>
			<li>Email: {{{ $alert->email }}}</li>
			<li>Stop: {{{ $alert->stop }}}</li>
			<li>Route: {{{ $alert->route }}}</li>
			<li>Departure: {{{ $alert->departure_time }}}</li>
			<li>Time to stop: {{{ $alert->time_to_stop }}} minutes</li>
		</ul>
	@endforeach
@stop
