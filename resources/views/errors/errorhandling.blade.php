<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>

      @vite('resources/css/app.css')
    @livewireStyles
    
    @stack('headerScript')
    @stack('css')
    <style>
        body {
            font-family: Inter, sans-serif;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white text-slate-900 min-h-screen flex items-center justify-center px-6">

    <div class="text-center max-w-md w-full">

        <div class="text-7xl font-bold tracking-tight mb-4 floating">
            {{ $code ?? '500' }}
        </div>

        <h1 class="text-2xl font-semibold mb-3">
            {{ $title ?? 'Something went wrong' }}
        </h1>

        <p class="text-slate-500 leading-relaxed mb-8">
            {{ $message ?? 'Unexpected error occurred.' }}
        </p>

        <div class="flex items-center justify-center gap-3">
            <button
                onclick="window.location.reload()"
                class="px-5 py-2.5 rounded-xl bg-slate-900 text-white hover:scale-105 transition"
            >
                Reload
            </button>

            <button
                onclick="window.history.back()"
                class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 hover:scale-105 transition"
            >
                Back
            </button>
        </div>

    </div>

</body>
</html>