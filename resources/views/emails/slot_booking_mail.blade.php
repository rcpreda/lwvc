<H4>Hi, {{$details['name']}}</H4>
<p>A new event has been schedule.</p>

<p><b>Event Type</b></p>
<p>{{$details['eventname']}}</p>

<p><b>Invitee:</b></p>
<p>{{$details['name']}}</p>

<p><b>Invitee Email:</b></p>
<p>{{$details['email']}}</p>

<p><b>Event Date/Time:</b></p>
<p>{{$details['slot'].', '.$details['newdateval'].'('.$details['timezone'].')'}}</p>

<p><b>Description</b></p>
<p>{{$details['description']}}</p>

<p>Thank You</p>

