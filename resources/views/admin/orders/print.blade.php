<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Imprimir Pedido - {{ $eventRequest->nombre_completo }}</title>
    
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        @media print {
            body {
                background-color: white;
            }
            .no-print {
                display: none !important;
            }
            .print-shadow-none {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body class="text-stone-800 antialiased min-h-screen p-4 md:p-8">

    <div class="max-w-3xl mx-auto">
        <!-- Controles de impresión -->
        <div class="no-print mb-6 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-stone-200">
            <p class="text-sm text-stone-500 font-medium">Vista de impresión del pedido</p>
            <div class="flex gap-3">
                <a href="/admin/event-requests" class="px-4 py-2 bg-stone-100 text-stone-700 rounded-lg text-sm font-medium hover:bg-stone-200 transition-colors">Volver</a>
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.728 13.5H17.27m-10.542 0A2.25 2.25 0 0 1 4.477 11.25V8.25a2.25 2.25 0 0 1 2.25-2.25h10.546a2.25 2.25 0 0 1 2.25 2.25v2.998A2.25 2.25 0 0 1 17.27 13.5m-10.542 0v4.499A2.25 2.25 0 0 0 8.978 20.25h6.046a2.25 2.25 0 0 0 2.25-2.25V13.5m-10.542 0h10.542" />
                    </svg>
                    Imprimir Documento
                </button>
            </div>
        </div>

        <!-- Documento -->
        <div class="bg-white p-8 md:p-12 rounded-2xl shadow-lg print-shadow-none relative overflow-hidden">
            <!-- Banda superior decorativa -->
            <div class="absolute top-0 left-0 w-full h-2 bg-primary-600"></div>

            <!-- Cabecera -->
            <div class="flex justify-between items-start border-b border-stone-100 pb-8 mb-8">
                <div>
                    <img src="{{ asset('images/logo-cpata-web.png') }}" alt="Cpata Logo" class="h-20 w-20 object-cover rounded-full drop-shadow-sm mb-4">
                    <h1 class="text-3xl font-bold text-stone-900 tracking-tight">Detalle de Pedido</h1>
                    <p class="text-stone-500 mt-1">Generado el {{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <div class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-stone-100 text-stone-700 border border-stone-200 mb-2">
                        Estado: {{ $eventRequest->estado?->getLabel() ?? $eventRequest->estado }}
                    </div>
                    <p class="text-stone-500 text-sm">Pedido #{{ str_pad($eventRequest->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-stone-500 text-sm mt-1">Recibido: {{ $eventRequest->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 2rem;">
                <!-- Información del Cliente -->
                <div>
                    <h2 class="text-lg font-semibold text-primary-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Datos del Cliente
                    </h2>
                    <div class="mt-4 bg-stone-50 p-5 rounded-xl border border-stone-100 flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Nombre Completo</span>
                            <span class="font-medium text-stone-900 text-base">{{ $eventRequest->nombre_completo }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Teléfono</span>
                            <span class="text-stone-800 text-base">{{ $eventRequest->telefono }}</span>
                        </div>
                        @if($eventRequest->email)
                        <div class="flex flex-col gap-1">
                            <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Email</span>
                            <span class="text-stone-800 text-base">{{ $eventRequest->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información del Evento -->
                <div>
                    <h2 class="text-lg font-semibold text-primary-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        Datos del Evento
                    </h2>
                    <div class="mt-4 bg-stone-50 p-5 rounded-xl border border-stone-100 flex flex-col gap-5">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Fecha</span>
                                <span class="font-medium text-stone-900 text-base">{{ $eventRequest->fecha_evento ? $eventRequest->fecha_evento->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Hora</span>
                                <span class="font-medium text-stone-900 text-base">{{ $eventRequest->hora_evento ? \Carbon\Carbon::parse($eventRequest->hora_evento)->format('H:i') . ' hs' : '-' }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Lugar del Evento</span>
                            <span class="text-stone-800 text-base">{{ $eventRequest->direccion_evento ?? 'A definir' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-stone-500 font-semibold text-xs uppercase tracking-wider">Cantidad de Invitados</span>
                            <span class="text-stone-800 text-base">{{ $eventRequest->cantidad_invitados ?? '-' }} personas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles del Producto -->
            <div style="margin-top: 3rem;">
                <h2 class="text-lg font-semibold text-primary-900 mb-4 flex items-center gap-2 border-b border-stone-100 pb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    Producto Solicitado
                </h2>
                
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-bold text-lg text-stone-900">{{ $eventRequest->product->name ?? 'Producto no especificado' }}</p>
                        <p class="text-stone-500 mt-1 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Opción seleccionada: <span class="font-medium text-stone-700">{{ $eventRequest->variant->label ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($eventRequest->observaciones_cliente || $eventRequest->observaciones_admin)
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($eventRequest->observaciones_cliente)
                <div>
                    <h3 class="text-sm font-semibold text-stone-700 mb-2 uppercase tracking-wide">Comentarios del Cliente</h3>
                    <div class="bg-yellow-50/50 border border-yellow-100 p-4 rounded-xl text-stone-700 text-sm whitespace-pre-line">
                        {{ $eventRequest->observaciones_cliente }}
                    </div>
                </div>
                @endif
                
                @if($eventRequest->observaciones_admin)
                <div>
                    <h3 class="text-sm font-semibold text-stone-700 mb-2 uppercase tracking-wide">Notas Internas (Admin)</h3>
                    <div class="bg-stone-50 border border-stone-200 p-4 rounded-xl text-stone-700 text-sm whitespace-pre-line">
                        {{ $eventRequest->observaciones_admin }}
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Footer documento -->
            <div class="mt-16 pt-8 border-t border-stone-100 text-center text-stone-400 text-xs">
                <p>Cpata Catering - Los mejores sabores en tu mesa</p>
                <p class="mt-1">Tel: (+54) 01133827965 • Email: cpatacatering@gmail.com</p>
            </div>
        </div>
    </div>

</body>
</html>
