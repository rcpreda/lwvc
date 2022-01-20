<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-gray-50">
        <div class="bg-white border border-gray-300 w-80 py-8 flex items-center flex-col mb-3">
            <h1 class="font-medium">Video Chat</h1>
            <a class="text-xs mt-2 text-gray-500">Create an account & start calling</a>
            <form class="mt-4 w-64 flex flex-col" method="post" action="{{ route('signup') }}">
                @csrf
                <input autofocus
                    class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                    id="email" name="name" value="{{ old('name') }}" placeholder="Name" type="text" required>
                <input autofocus
                    class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                    id="email" name="email" value="{{ old('email') }}" placeholder="Email" type="email" required>
                <input autofocus
                    class="text-xs w-full mb-4 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                    id="password" name="password" placeholder="Password" type="password" required>
                <button class="text-sm text-center cursor-pointer bg-blue-600 text-white py-1 rounded font-medium">
                    Sign up
                </button>
            </form>
            <div class="text-center w-80 py-4">
                <span class="text-sm">Already have an account?</span>
                <a class="text-blue-500 text-sm font-semibold" href="/login">Login</a>
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
    </div>
</body>
</html>