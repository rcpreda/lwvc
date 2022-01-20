<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-gray-50">
        <div class="bg-white border border-gray-300 w-80 py-8 flex items-center flex-col mb-3">
            <h1 class="font-medium">Video Chat</h1>
            <form class="mt-8 w-64 flex flex-col" method="post" action="/login">
                @csrf
                <input autofocus
                    class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                    id="email" name="email" placeholder="Email" type="email" value="{{ old('email') }}" required>
                <input autofocus
                    class="text-xs w-full mb-4 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                    id="password" name="password" placeholder="Password" type="password" required>
                <div class="flex gap-1.5 mb-4 items-center text-xs text-gray-500">
                    <input type="checkbox" name="remember">
                    <span class="-mt-0.5">Remember me</span>
                </div>
                <button class=" text-sm text-center cursor-pointer bg-blue-600 text-white py-1 rounded font-medium">
                    Log In
                </button>
            </form>
            <div class="flex justify-evenly space-x-2 w-64 mt-4">
                <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
                <span class="flex-none uppercase text-xs text-gray-400 font-semibold">or</span>
                <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
            </div>
            <a class="text-xs text-blue-900 mt-4 cursor-pointer -mb-4">Forgot password?</a>
        </div>
        <div class="bg-white border border-gray-300 text-center w-80 py-4">
            <span class="text-sm">Don't have an account?</span>
            <a class="text-blue-500 text-sm font-semibold" href="/signup">Sign up</a>
        </div>
        @if ($errors->any())
            <div class="text-xs text-red-400">
                    @foreach ($errors->all() as $error)
                        <div class="mt-1">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>