<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event</title>
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
       <div id="app">
           <App/>
       </div>
       <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>