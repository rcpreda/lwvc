<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Video Chat</title>
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app" class="w-full h-screen overflow-auto">
           <video-call-app :auth-user="{{ json_encode(auth()->user()) }}"/>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
