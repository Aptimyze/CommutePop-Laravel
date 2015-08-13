@extends('layouts.main')
@section('content')
	<h2>Your Active Alerts</h2>
	@if (count($alerts)==0)
		<p>You haven't created any alerts yet!</p>
	@else
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
	@endif
    <a href="/alerts/new"><button class="radius">Create a New Alert</button></a>
@stop
