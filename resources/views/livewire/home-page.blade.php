<div x-data="{
    showToast: false,
    init() {
        window.addEventListener('order-submitted', () => {
            this.showToast = true;
            setTimeout(() => this.showToast = false, 5000);
        });
    }
}">

    {{-- HERO SECTION --}}
    <section class="relative bg-stone-900 overflow-hidden min-h-[80vh] flex items-center text-center justify-center">
        <div class="absolute inset-0">
            <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-60">
                <source src="{{ asset('videos/video-hero.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/50"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center justify-center text-center">
            <div class="max-w-4xl flex flex-col items-center">
                <span class="inline-block text-white font-semibold tracking-[0.2em] text-sm sm:text-base mb-6 drop-shadow-md">
                    LOS MEJORES SABORES EN TU MESA
                </span>
                <h1 class="text-5xl lg:text-7xl font-serif text-white tracking-widest leading-tight mb-10 drop-shadow-lg" style="font-family: 'Times New Roman', serif;">
                    CATERING PARA <br> EVENTOS
                </h1>
                
                <div class="mt-4 flex justify-center w-full">
                    <a href="#catalogo" class="px-8 py-4 bg-primary-600 text-white font-bold tracking-wider text-sm sm:text-base hover:bg-primary-700 transition-all duration-300 text-center uppercase shadow-lg border-none w-full sm:w-auto">
                        PEDÍ TU DELIVERY DE PERNIL
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Decorative shape --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-stone-50" style="clip-path: polygon(0 100%, 100% 100%, 100% 0, 0 100%);"></div>
    </section>

    {{-- CATALOGO --}}
    <section id="catalogo" class="py-24 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-heading font-extrabold text-stone-900 mb-4">Nuestras <span class="text-primary-600">Especialidades</span></h2>
                <p class="text-lg text-stone-600">Elegí el producto ideal para tu evento y nosotros lo preparamos.</p>
            </div>

            @foreach($categories as $category)
                @php
                    $categoryProducts = $products->where('category_id', $category->id);
                @endphp

                @if($categoryProducts->count() > 0)
                    <div class="mb-20">
                        <div class="flex items-center gap-4 mb-6 sm:mb-8">
                            @if($category->icon)
                                <span class="text-2xl sm:text-3xl">{{ $category->icon }}</span>
                            @endif
                            <h3 class="text-2xl sm:text-3xl font-heading font-bold text-stone-800">{{ $category->name }}</h3>
                            <div class="flex-grow h-px bg-stone-200"></div>
                        </div>

                        <div class="flex flex-col gap-8 sm:gap-12">
                            @foreach($categoryProducts as $product)
                                <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col lg:flex-row group">
                                    @if(!empty($product->images) && count($product->images) > 0)
                                        <div class="relative w-full lg:w-1/5 h-48 sm:h-64 lg:h-auto overflow-hidden bg-stone-200">
                                            @if(count($product->images) > 1)
                                                <div x-data="{ activeSlide: 0, slides: {{ count($product->images) }} }" class="relative w-full h-full group/carousel">
                                                    <div class="w-full h-full flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${activeSlide * 100}%)`">
                                                        @foreach($product->images as $img)
                                                            <div class="w-full h-full flex-shrink-0">
                                                                <img src="{{ Storage::url($img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button @click.stop="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-1.5 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button @click.stop="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-1.5 opacity-0 group-hover/carousel:opacity-100 transition-opacity z-20">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                </div>
                                            @else
                                                <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @endif
                                            @if($product->featured)
                                                <div class="absolute top-4 right-4 bg-primary-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg z-30">
                                                    Recomendado
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        @if($product->featured)
                                            <div class="absolute top-4 right-4 bg-primary-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg z-10">
                                                Recomendado
                                            </div>
                                        @endif
                                    @endif
                                    <div class="w-full lg:w-4/5 p-4 sm:p-8 flex-grow flex flex-col">
                                        <h4 class="text-xl sm:text-3xl font-heading font-bold text-stone-900 mb-1 sm:mb-2">{{ $product->name }}</h4>
                                        <div class="mb-6 sm:mb-8">
                                            <p class="text-sm sm:text-lg text-stone-600">{{ $product->short_description }}</p>
                                            @if($product->variants->count() > 0)
                                                <p class="text-primary-500 font-medium text-xs uppercase tracking-wide mt-2">Hace clic en + para ver qué incluye cada opción</p>
                                            @endif
                                        </div>
                                        
                                        @if($product->variants->count() > 0)
                                            <div x-data="{ expanded: false }" class="mt-auto">
                                                <div :class="expanded ? '' : 'max-h-[110px] sm:max-h-none overflow-hidden relative'">
                                                    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-2 sm:gap-3">
                                                        @foreach($product->variants as $variant)
                                                            <div wire:click="openOrderModal({{ $product->id }}, {{ $variant->id }})" class="cursor-pointer flex justify-between items-center p-2 sm:p-3 rounded-lg bg-stone-50 border border-stone-100 hover:border-primary-300 transition-colors">
                                                                <div>
                                                                    <div class="font-bold text-stone-800 text-xs sm:text-sm mb-0 sm:mb-1">{{ $variant->label }}</div>
                                                                    <div class="font-black text-base sm:text-lg text-primary-600">${{ number_format($variant->price, 0, ',', '.') }}</div>
                                                                </div>
                                                                <div class="flex items-center ml-1">
                                                                    <button wire:loading.attr="disabled" class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-secondary-500 text-white flex items-center justify-center hover:bg-secondary-600 transition-colors shadow-sm disabled:opacity-50" title="Pedir este">
                                                                        <svg wire:loading.remove wire:target="openOrderModal({{ $product->id }}, {{ $variant->id }})" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                                        <svg wire:loading wire:target="openOrderModal({{ $product->id }}, {{ $variant->id }})" class="w-3 h-3 sm:w-4 sm:h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    
                                                    <!-- Gradient Fade Overlay for Mobile -->
                                                    <div x-show="!expanded" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none sm:hidden"></div>
                                                </div>
                                                
                                                <!-- Ver más button for Mobile -->
                                                <div x-show="!expanded" class="mt-2 flex justify-center sm:hidden">
                                                    <button @click="expanded = true" class="text-sm text-primary-600 font-semibold hover:text-primary-700 flex items-center gap-1 bg-primary-50 px-4 py-1.5 rounded-full border border-primary-100">
                                                        Ver más opciones
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <button wire:click="openOrderModal({{ $product->id }})" wire:loading.attr="disabled" class="mt-auto w-full md:w-auto px-8 py-3 rounded-xl border-2 border-primary-500 text-primary-600 font-bold hover:bg-primary-500 hover:text-white transition-colors flex items-center justify-center gap-2 disabled:opacity-50">
                                                <span wire:loading.remove wire:target="openOrderModal({{ $product->id }})">Solicitar Presupuesto</span>
                                                <span wire:loading wire:target="openOrderModal({{ $product->id }})">Cargando...</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- GALERÍA DE IMÁGENES (Marquee) --}}
    @if($galleries->count() > 0)
    <section id="galeria" class="py-20 bg-stone-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 text-center">
            <h2 class="text-3xl font-heading font-bold text-white mb-4">Nuestros <span class="text-primary-400">Trabajos</span></h2>
            <p class="text-stone-400">Mirá la calidad de nuestros productos</p>
        </div>
        
        <div class="flex gap-6 px-4 pb-4 overflow-x-auto snap-x snap-mandatory hide-scrollbar" style="scrollbar-width: none;">
            @foreach($galleries as $gallery)
                <div class="flex-none w-72 h-72 md:w-96 md:h-96 snap-center rounded-2xl overflow-hidden relative group">
                    <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @if($gallery->caption)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <p class="text-white font-medium text-lg">{{ $gallery->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- TESTIMONIOS --}}
    @if($testimonials->count() > 0)
    <section id="testimonios" class="py-24 bg-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-heading font-extrabold text-stone-900 mb-4">Lo que dicen <span class="text-primary-600">Nuestros Clientes</span></h2>
                <p class="text-lg text-stone-600">La satisfacción de quienes nos eligen es nuestra mejor carta de presentación.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 hover:shadow-lg transition-shadow relative">
                        <div class="absolute -top-4 right-8 text-6xl text-primary-200 font-serif">"</div>
                        <div class="flex text-secondary-400 mb-4">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-stone-700 mb-6 italic">"{{ $testimonial->content }}"</p>
                        <div class="font-bold text-stone-900">{{ $testimonial->client_name }}</div>
                        <div class="text-sm text-stone-500">{{ $testimonial->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ORDER MODAL --}}
    @if($isOrderModalOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-data @keydown.escape.window="$wire.closeOrderModal()">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm transition-opacity" wire:click="closeOrderModal"></div>
        
        {{-- Modal Panel --}}
        <div class="relative bg-white shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto custom-scrollbar flex flex-col sm:flex-row transform transition-all">
            
            {{-- Left Side: Product Info (Hidden on small mobile) --}}
            <div class="hidden sm:block sm:w-2/5 bg-stone-50 p-8 border-r border-stone-100 flex flex-col">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold font-heading text-stone-900 mb-2">Resumen de Pedido</h3>
                    <p class="text-stone-500">Estás a un paso de confirmar tu evento con nosotros.</p>
                </div>
                
                @if($selectedProduct)
                    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm mb-6 flex-grow">
                        @if(!empty($selectedProduct->images) && count($selectedProduct->images) > 0)
                            <img src="{{ Storage::url($selectedProduct->images[0]) }}" class="w-full h-32 object-cover rounded-xl mb-4" alt="Product">
                        @endif
                        <h4 class="font-bold text-lg text-stone-900">{{ $selectedProduct->name }}</h4>
                        @if($selectedVariant)
                            <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 bg-primary-50 rounded-lg text-primary-700 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $selectedVariant->label }}
                            </div>
                            @if($selectedVariant->description)
                                <p class="mt-3 text-sm text-stone-600 leading-relaxed">{!! nl2br(e($selectedVariant->description)) !!}</p>
                            @endif
                            <div class="mt-4 font-bold text-2xl text-stone-900">
                                ${{ number_format($selectedVariant->price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>
                @endif
                <div class="mt-auto text-sm text-stone-500 text-center">
                    Pago seguro. Nos comunicaremos con vos para coordinar los detalles.
                </div>
                <br>
            </div>
            
            {{-- Right Side: Form --}}
            <div class="w-full sm:w-3/5 p-6 sm:p-8 relative">
                <button wire:click="closeOrderModal" class="absolute top-4 right-6 text-stone-400 hover:text-stone-600 bg-stone-100 hover:bg-stone-200 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                
                <h3 class="text-2xl font-bold font-heading text-stone-900 mb-6 sm:hidden">Completar Pedido</h3>
                
                <form wire:submit.prevent="submitOrder" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Nombre</label>
                            <input wire:model="nombre" type="text" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="Juan">
                            @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Apellido</label>
                            <input wire:model="apellido" type="text" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="Pérez">
                            @error('apellido') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Teléfono / WhatsApp</label>
                            <input wire:model="telefono" type="tel" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="1122334455....">
                            @error('telefono') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Email</label>
                            <input wire:model="email" type="email" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="correo@ejemplo.com">
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <hr class="border-stone-100">
                    
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-2">Dirección del Evento</label>
                        <input wire:model="direccion_evento" type="text" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="Calle, Número, Localidad">
                        @error('direccion_evento') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div x-data="{
                            init() {
                                flatpickr(this.$refs.picker, {
                                    locale: 'es',
                                    minDate: new Date().fp_incr(1),
                                    dateFormat: 'Y-m-d',
                                    disableMobile: true,
                                    onChange: (selectedDates, dateStr) => {
                                        $wire.set('fecha_evento', dateStr);
                                    }
                                });
                            }
                        }">
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Fecha</label>
                            <input x-ref="picker" wire:model="fecha_evento" type="text" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none bg-white" placeholder="Seleccionar fecha..." readonly>
                            @error('fecha_evento') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Hora (Aprox)</label>
                            <input wire:model="hora_evento" type="time" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none">
                            @error('hora_evento') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-2">Invitados</label>
                            <input wire:model="cantidad_invitados" type="number" min="1" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none" placeholder="0">
                            @error('cantidad_invitados') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-2">Observaciones</label>
                        <textarea wire:model="observaciones_cliente" rows="2" class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 transition-all outline-none resize-none" placeholder="Algún detalle a tener en cuenta..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4 rounded-xl bg-stone-900 text-white font-bold text-lg hover:bg-primary-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="submitOrder">Enviar Pedido</span>
                        <span wire:loading wire:target="submitOrder">Procesando...</span>
                        <svg wire:loading.remove wire:target="submitOrder" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- SUCCESS TOAST --}}
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-24 right-6 bg-white p-4 rounded-2xl shadow-2xl border-l-4 border-green-500 flex items-center gap-4 z-50 max-w-sm"
         style="display: none;">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500 flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-stone-900">¡Pedido Enviado!</h4>
            <p class="text-sm text-stone-500">Nos comunicaremos con vos a la brevedad.</p>
        </div>
        <button @click="showToast = false" class="text-stone-400 hover:text-stone-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

</div>
