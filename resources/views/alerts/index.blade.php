@extends('layouts.main')
@section('content')
	<h2>{!! Auth::user()->name !!}'s Active Alerts</h2>
	@if (count($alerts)==0)
		<p>You don't have any alerts yet!</p>
	@else
	@foreach($alerts as $alert)
		<h4><a href="{!! route('alerts.show', ['id' => $alert->id]) !!}">{{{ $alert->departure_time }}} departure</a></h4>
		<ul class="no-bullet button-group">
			<li><a href="{!! route('alerts.edit', ['id' => $alert->id]) !!}"><button class="tiny success radius">Edit</button></a></li>
			<li>{!! Form::model($alert, ['route' => ['alerts.destroy', $alert->id], 'method' => 'DELETE']) !!}
				{!! Form::submit('Delete', ['class' => 'tiny alert button radius']) !!}
			{!! Form::close() !!}</li>
		</ul>
	@endforeach
	@endif
	<br>
    <a href="/alerts/create"><button class="radius">Create a New Alert</button></a>
@stop
