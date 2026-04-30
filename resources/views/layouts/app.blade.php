<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InklusifEdu</title>

    @vite('resources/css/app.css')
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
   
    
<style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .hero-gradient {
            background: radial-gradient(circle at 80% 20%, #e0f2fe 0%, transparent 40%),
                        radial-gradient(circle at 10% 80%, #eff6ff 0%, transparent 30%);
        }
        .dark .hero-gradient {
            background: radial-gradient(circle at 80% 20%, #1e293b 0%, transparent 40%),
                        radial-gradient(circle at 10% 80%, #0f172a 0%, transparent 30%);
            background-color: #020617;
        }
        .card-shadow {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
        }
        .dark .card-shadow {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.4);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body >

    {{ $slot }}

    @livewireScripts
    @stack('scripts')

</body>
</html>