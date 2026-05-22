<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Cpata - Delivery de Pernil y Catering Profesional para tus eventos más importantes. Especialistas en pernil feteado y mesas frías.' }}">
    <meta name="keywords" content="catering, pernil, delivery de pernil, eventos, comida para fiestas, buenos aires, zona oeste">
    <meta name="author" content="Cpata Catering">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Cpata - Delivery de Pernil y Catering' }}">
    <meta property="og:description" content="{{ \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Cpata - Delivery de Pernil y Catering Profesional. Especialistas en pernil feteado.' }}">
    <meta property="og:image" content="{{ asset('images/hero-bg.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? 'Cpata - Delivery de Pernil y Catering' }}">
    <meta property="twitter:description" content="{{ \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Cpata - Delivery de Pernil y Catering Profesional. Especialistas en pernil feteado.' }}">
    <meta property="twitter:image" content="{{ asset('images/hero-bg.jpg') }}">

    <title>{{ $title ?? 'Cpata - Delivery de Pernil y Catering' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Flatpickr for Date Selection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</head>
<body class="antialiased bg-stone-50 text-stone-900 flex flex-col min-h-screen relative">

    {{-- HEADER --}}
    <header class="fixed w-full top-0 z-50 glass transition-all duration-300" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo-cpata-web.png') }}" alt="Cpata Logo" class="h-14 w-14 object-cover rounded-full group-hover:scale-105 transition-transform drop-shadow-md">
                    </a>
                </div>
                
                {{-- Desktop Menu --}}
                <nav class="hidden md:flex gap-4 lg:gap-8">
                    <a href="/" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Inicio</a>
                    <a href="#catalogo" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Delivery de Pernil</a>
                    <a href="#catalogo" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Catering</a>
                    <a href="#nosotros" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Nosotros</a>
                    <a href="#contacto" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Contacto</a>
                    <a href="#galeria" class="text-stone-600 hover:text-primary-500 font-medium transition-colors">Eventos</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="#catalogo" class="px-6 py-2.5 rounded-full bg-primary-500 text-white font-medium hover:bg-primary-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Hacer Pedido
                    </a>
                </div>

                {{-- Mobile menu button --}}
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-stone-600 hover:text-stone-900 focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Panel --}}
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-stone-100 absolute w-full shadow-xl">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="/" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Inicio</a>
                <a href="#catalogo" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Delivery de Pernil</a>
                <a href="#catalogo" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Catering</a>
                <a href="#nosotros" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Nosotros</a>
                <a href="#contacto" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Contacto</a>
                <a href="#galeria" class="block px-3 py-3 rounded-md text-base font-medium text-stone-700 hover:text-primary-500 hover:bg-stone-50">Eventos</a>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-primary-900 text-stone-300 py-10 md:py-16 mt-12 md:mt-20 relative overflow-hidden border-t-4 border-primary-500 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 text-center">
                <div class="flex flex-col items-center">
                    <h3 class="text-white font-serif text-xl sm:text-2xl mb-2 md:mb-4">Nos ubicamos</h3>
                    <p class="text-stone-400 text-sm">Tenemos nuestras oficinas en Escobar<br>y CABA</p>
                </div>
                <div class="flex flex-col items-center">
                    <h3 class="text-white font-serif text-xl sm:text-2xl mb-2 md:mb-4">Nuestros teléfonos</h3>
                    <p class="text-stone-400 text-sm">(+54) 01133827965</p>
                </div>
                <div class="flex flex-col items-center">
                    <h3 class="text-white font-serif text-xl sm:text-2xl mb-2 md:mb-4">Nuestro Email</h3>
                    <p class="text-stone-400 text-sm">cpatacatering@gmail.com</p>
                </div>
            </div>
            
            <div class="mt-8 md:mt-16 flex flex-col items-center justify-center space-y-6">
                <div class="flex space-x-6">
                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/cpata_pernil/" target="_blank" class="w-12 h-12 rounded-lg bg-[#b5c2cd] flex items-center justify-center text-white hover:bg-[#e1306c] transition-colors shadow-sm">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="border-t border-primary-800/50 mt-8 md:mt-12 pt-6 md:pt-8 flex flex-col md:flex-row justify-between items-center text-xs md:text-sm text-center md:text-left">
                <p>&copy; {{ date('Y') }} Cpata Catering. Todos los derechos reservados.</p>
                <p class="mt-2 md:mt-0 text-stone-400">Desarrollado por <a href="https://enzoamarilla.dev" target="_blank" class="font-bold text-primary-400 hover:text-primary-300 transition-colors">enzoamarilla.dev</a></p>
            </div>
        </div>
    </footer>

    <!-- <a href="https://wa.me/{{ config('app.whatsapp') }}" target="_blank" class="fixed bottom-6 right-6 w-14 h-14 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 hover:shadow-green-500/30 transition-all z-50">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a> -->

    <script>
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            if (window.scrollY > 20) {
                header.classList.add('shadow-md', 'py-1');
                header.classList.remove('py-2');
            } else {
                header.classList.remove('shadow-md', 'py-1');
                header.classList.add('py-2');
            }
        });

        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
    
    @livewireScripts
</body>
</html>
