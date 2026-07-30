<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FisioCare Ayla' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter text-ink antialiased">
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-primary/5 to-accent/5 px-4 py-10">
        <div class="w-full max-w-md">
            <a href="/" class="mb-6 flex items-center justify-center gap-2 text-sm font-medium text-primary hover:text-accent-dark">
                <i class="fa-solid fa-arrow-left"></i>
                Volver al inicio
            </a>

            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-soft-lg">
                <div class="mb-6 flex flex-col items-center text-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla" class="mb-3 h-14 w-14 rounded-xl object-cover">
                    <h1 class="font-poppins text-2xl font-bold text-ink">{{ $heading ?? 'FisioCare Ayla' }}</h1>
                    @if(isset($subheading))
                        <p class="mt-1 text-sm text-slate-500">{{ $subheading }}</p>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
