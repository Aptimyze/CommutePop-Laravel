	    	<h5>Where do you want your alert sent?</h5>
		    <div class="row">
		    	<div class="large-4 columns">
		    		{!! Form::label('email', 'Email') !!}
			    	{!! Form::text('email', null, ['placeholder' => 'your@email.com', 'required' => 'required']) !!}
				    {!! $errors->first('email', '<small class="error">:message</small>'); !!}
			    </div>
			</div><br>
	    	<h5>What's your departure info? <a class="inline tiny" target="_blank" href="http://trimet.org/ride/stop_select_form.html"><span style="font-size: 0.6em;">(click here to look up your stop id)</span></a></h5>
	    	<div class="row">
			    <div class="large-2 columns left">
			    	{!! Form::label('route', 'Bus/Train number') !!}
			    	{!! Form::text('route', null, ['placeholder' => '15', 'required' => 'required']) !!}
				    {!! $errors->first('route', '<small class="error">:message</small>'); !!}
			    </div>
		    	<div class="large-2 columns left">
			    	{!! Form::label('stop', 'Stop Id') !!}
			    	{!! Form::text('stop', null, ['placeholder' => '428', 'required' => 'required']) !!}
				    {!! $errors->first('stop', '<small class="error">:message</small>'); !!}
			    </div>
			</div><br>
	    	<h5>What's the earliest you would <strong>leave</strong> to catch your bus or train?</h5>
	    	<div class="row">
			    <div class="large-2 columns left">
			    	{!! Form::input('time', 'departure_time', null, ['placeholder' => '5:15pm', 'required' => 'required']) !!}
				    {!! $errors->first('departure_time', '<small class="error">:message</small>'); !!}
			    </div>
			</div><br>
	    	<h5>And how long does it take to get to your stop <em>from your desk</em>?</h5>
	    	<div class="row">
			    <div class="large-2 columns left">
		    		<div class="row collapse">
		    			<div class="small-6 columns">
	    			    	{!! Form::text('time_to_stop', null, ['placeholder' => '8', 'required' => 'required']) !!}
						    {!! $errors->first('time_to_stop', '<small class="error">:message</small>'); !!}
					    </div>
					    <div class="small-6 columns">
					    	<span class="postfix">minutes</span>
					    </div>
					</div>
				</div>
			</div>
			{!! Form::hidden('lead_time', '5') !!} {{-- Todo: add this option --}}