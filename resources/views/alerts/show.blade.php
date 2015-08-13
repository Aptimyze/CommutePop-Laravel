@extends('layouts.main')
@section('content')
	<h4>Sending to: {{{ $alert->email }}}</h4>
	<h4>Bus/Train number: {{{ $alert->route }}}</h4>
	<h4>Stop ID: {{{ $alert->stop }}}</h4>
	<h4>Desk departure time: {{{ $alert->departure_time }}}</h4>
	<h4>Time to get to stop: {{{ $alert->time_to_stop }}} minutes</h4>
	<h4>Alert to be sent at: {{{ Carbon\Carbon::parse($alert->alert_time)->format('g:ia') }}}</h4>
	<a href="{!! route('alerts.index') !!}" class="tiny radius button">back</a>
@stop