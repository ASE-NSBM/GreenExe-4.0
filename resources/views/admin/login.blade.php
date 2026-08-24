<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — {{ config('greenexe.event.name') }}</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center bg-dark-navy px-4">
    <div class="gx-grid-bg fixed inset-0 -z-10"></div>

    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <h1 class="font-display text-2xl font-bold text-white">{{ config('greenexe.event.name') }}</h1>
            <p class="mt-1 text-sm text-cyan-tech">Administrator sign in</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl border border-fresh-green/40 bg-fresh-green/10 px-4 py-3 text-sm" role="status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}" class="gx-card space-y-5">
            @csrf

            <div>
                <label class="gx-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="gx-input" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email') <p class="gx-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="gx-label" for="password">Password</label>
                <input id="password" name="password" type="password" class="gx-input" required autocomplete="current-password">
                @error('password') <p class="gx-error">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-light-gray/70" for="remember">
                <input id="remember" name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-dark-navy text-smart-green">
                Remember me
            </label>

            <button type="submit" class="gx-btn-primary w-full">Sign in</button>
        </form>

        <p class="mt-6 text-center text-xs text-light-gray/40">
            <a href="{{ route('home') }}" class="hover:text-cyan-tech">← Back to the public site</a>
        </p>
    </div>
</body>
</html>
