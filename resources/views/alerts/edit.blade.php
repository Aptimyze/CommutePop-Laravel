@extends('layouts.main')
@section('content')
	    <h1>Edit your alert</h1>
	    <br><br>
	    {!! Form::model($alert, ['route' => ['alerts.update', $alert->id], 'method' => 'PUT']) !!}
	    	@include('alerts.partials._form')
		   	{!! Form::submit('Confirm edit', ['class' => 'success button radius']) !!}
	    {!! Form::close() !!}
	    <a href="{!! route('alerts.index') !!}"><button class="tiny alert radius">Cancel</button></a>
@stop