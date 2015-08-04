<!DOCTYPE xhtml1-strict>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
	/* ///// RESET STYLES /////*/
	</style>
</head>
<h3>Hi! Here's your CommutePop Alert.</h3>
<h4>Bottom line: leave at <span style="color: red;">{!! $emailData['arrivalTimes'][0] !!}</span></h4>
<h6>FYI, we got the info below from Trimet at {{ $emailData['queryTime'] }}.</h6>
<h5>When your upcoming rides leave from {{ $emailData['stopName'] . $emailData['routeDirection'] }}:</h5>
<ol>
 @foreach ($emailData['arrivalTimes'] as $arrivalTime)
	<li>{!! $arrivalTime !!}</li>
@endforeach
</ol>
<h5>When you should leave your desk to catch them:</h5>
<ol>
@foreach ($emailData['deskDepartures'] as $deskDeparture)
	<li>{!! $deskDeparture !!}</li>
@endforeach
</ol>
<p>Thanks for using CommutePop! As always, you can let us know what you think by responding to this email.</p>
{{-- <p>To edit or cancel this alert, <a href="commutepop.com/cancel/{!! $alert->id !!}">click here.</a></p> --}}