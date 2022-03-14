<H4>Hi, {{$details['name']}}</H4>
<p><b>Your reminder for event</b>-{{$details['eventname']}}</p>
<p><b>Event Date/Time:</b></p>
<p>{{$details['slot'].', '.$details['datetime'].'('.$details['timezone'].')'}}</p>

<p><b>Description</b></p>
<p>{{strip_tags($details['description'])}}</p>

<p>Thank You</p>

