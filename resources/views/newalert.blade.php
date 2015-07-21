@extends('layouts.main')
@section('content')
    <h1>Create an alert</h1>
    <h4>Great! Let's get you set up. Fill out the form below, and we'll see what routes and stops you might want alerts for.</h4>
    {!! Form::open(array('url' => 'new', 'method' => 'get')) !!}
	    {{-- <div class="row">
	    	<div class="large-4 columns">
		    	{!! Form::label('email', 'Email Address to Receive Alerts') !!}
		    	{!! Form::text('email') !!}
		    </div>
		</div> --}}
    	<h4>Your Commute</h4>
    	<h5>From</h5>
    	<div class="row">
	    	<div class="large-4 columns left">
		    	{!! Form::label('street_start', 'Street') !!}
		    	{!! Form::text('street_start') !!}
		    </div>
		    <div class="large-3 columns left">
				{!! Form::label('city_start', 'City') !!}
				{!! Form::text('city_start') !!}
			</div>
		    <div class="large-2 columns left">
				{!! Form::label('state_start', 'State') !!}
				{!! Form::select('state_start', ['Oregon', 'Washington']) !!}
			</div>
		    <div class="large-2 columns left">
				{!! Form::label('zip_start', 'Zipcode') !!}
				{!! Form::text('zip_start') !!}
			</div>
		</div>
    	<h5>To</h5>
     	<div class="row">
		   	<div class="large-4 columns left">
		    	{!! Form::label('street_end', 'Street') !!}
		    	{!! Form::text('street_end') !!}
		    </div>
		    <div class="large-3 columns left">
				{!! Form::label('city_end', 'City') !!}
				{!! Form::text('city_end') !!}
			</div>
		    <div class="large-2 columns left">
				{!! Form::label('state_end', 'State') !!}
				{!! Form::select('state_end', ['Oregon', 'Washington']) !!}
			</div>
		    <div class="large-2 columns left">
				{!! Form::label('zip_end', 'Zipcode') !!}
				{!! Form::text('zip_end') !!}
			</div>
		</div>
    	{!! Form::submit('Submit', ['class' => 'button radius']) !!}
    {!! Form::close() !!}
    
    {{-- {{{ var_dump($validator->errors()) }}} --}}
    {{{ var_dump($_GET) }}}
@stop
