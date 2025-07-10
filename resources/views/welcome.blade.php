<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serena Care</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <!-- Header con navegación -->
    <header class="absolute top-0 right-0 p-6">
        <nav class="flex items-center gap-4">
            @auth
                <a href="{{ url('/app/dashboard') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Dashboard
                </a>
            @else
                <a href="/app/login"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Iniciar Sesión
                </a>
            @endauth
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="text-center">
        <div class="mb-8">
            <h1 class="text-6xl font-bold text-gray-800 mb-2">
                Serena Care
            </h1>
            <h2 class="text-4xl font-medium text-blue-600">
                Eventos
            </h2>
        </div>

        <!-- Imagen de eventos -->
        <div class="max-w-2xl mx-auto">
            <img src="https://images.unsplash.com/photo-1530103862676-de8c9debad1d?q=80&w=1000&auto=format&fit=crop" 
                 alt="Eventos - Fiestas y Celebraciones" 
                 class="w-full h-auto rounded-2xl shadow-2xl object-cover">
        </div>

        <!-- Descripción opcional -->
        <div class="mt-8 max-w-lg mx-auto">
            <p class="text-lg text-gray-600 leading-relaxed">
                Tu plataforma para gestionar y disfrutar de eventos especiales, 
                fiestas y celebraciones inolvidables.
            </p>
        </div>
    </main>
</body>
</html>