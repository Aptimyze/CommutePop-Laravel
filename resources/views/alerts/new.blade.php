@extends('layouts.main')
@section('content')
	    <h1>Create an alert</h1>
	    <h4>Let's get you set up. Fill out the form below, and we'll schedule an alert.</h4>
	    <br><br>
	    {!! Form::open(['route' => 'alerts.store']) !!}
	    	@include('alerts.partials._form')
		   	{!! Form::submit('Submit', ['class' => 'button radius']) !!}
	    {!! Form::close() !!}
	    <a href="{!! route('alerts.index') !!}"><button class="tiny alert radius">Cancel</button></a>
@stop
