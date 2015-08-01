<h2>Hi! We got the info below from Trimet at {{{ $emailData['queryTime'] }}}.</h2>
<h2>When your ride leaves from {{{ $emailData['stopName'] . $emailData['routeDirection'] }}}:</h2>
<ul>
{{-- @foreach ($emailData['arrivalTimes'] as $arrivalTime)
	<li>{{{ $arrivalTime }}}</li>
@endforeach
</ul>
<h2>When you should leave your desk:</h2>
<ul>
@foreach ($emailData['deskDepartures'] as $deskDeparture)
	<li>{{{ $deskDeparture }}}</li>
@endforeach
</ul> --}}
<p>Thanks for using CommutePop! As always, you can let us know what you think by responding to this email.</p>
{{-- <p>To cancel this alert, <a href="commutepop.com/cancel/?alertid={{{ $alert->id }}}">click here.</a></p> --}}