@extends('layouts.main')
@section('content')
	<h2>{!! Auth::user()->name !!}'s Active Alerts</h2>
	@if (count($alerts)==0)
		<p>You don't have any alerts yet!</p>
	@else
	<hr>
	@foreach($alerts as $alert)
		<h4><a href="{!! route('alerts.show', ['id' => $alert->id]) !!}">{{{ App\AlertHandler::describe($alert, false) }}}</a></h4>
		<ul class="button-group">
			<li><a href="{!! route('alerts.edit', ['id' => $alert->id]) !!}" class="success button tiny">Edit</a></li>
			<li>{!! Form::model($alert, ['route' => ['alerts.destroy', $alert->id], 'method' => 'DELETE']) !!}
				{!! Form::submit('Delete', ['class' => 'tiny alert button']) !!}
			{!! Form::close() !!}</li>
		</ul>
		<hr>
	@endforeach
	@endif
	<br>
    <a href="/alerts/create"><button class="radius">Create a New Alert</button></a>
    <br>
@stop
