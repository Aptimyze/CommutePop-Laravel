@extends('layouts.main')
@section('content')
	<h2>All Alert Recipients</h2>
	@foreach($alerts as $alert)
	<h3>Alert {{{ $alert->id }}}:</h3>
		<ul>
			<li>Email: {{{ $alert->email }}}</li>
			<li>Stop: {{{ $alert->stop }}}</li>
			<li>Route: {{{ $alert->route }}}</li>
			<li>Departure: {{{ $alert->route }}}</li>
			<li>Route: {{{ $alert->route }}}</li>
		</ul>
	@endforeach
@stop
