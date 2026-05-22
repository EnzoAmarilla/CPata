<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class HomePage extends Component
{
    public $categories;
    public $products;
    public $testimonials;
    public $galleries;
    
    // Order Modal state
    public $isOrderModalOpen = false;
    public $selectedProduct = null;
    public $selectedVariant = null;
    
    // Form fields
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $direccion_evento;
    public $fecha_evento;
    public $hora_evento;
    public $cantidad_invitados;
    public $observaciones_cliente;

    protected $rules = [
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'email' => 'required|email',
        'telefono' => 'required|string',
        'direccion_evento' => 'required|string',
        'fecha_evento' => 'required|date',
        'hora_evento' => 'required',
        'cantidad_invitados' => 'required|numeric|min:1',
    ];

    public function mount()
    {
        $this->categories = \App\Models\Category::where('active', true)->orderBy('order')->get();
        $this->products = \App\Models\Product::with(['variants' => function($q) {
                $q->where('active', true)->orderBy('order');
            }])
            ->where('active', true)
            ->orderBy('order')
            ->get();
        $this->testimonials = \App\Models\Testimonial::where('active', true)->orderByDesc('created_at')->take(5)->get();
        $this->galleries = \App\Models\Gallery::where('active', true)->orderBy('order')->get();
    }

    public function openOrderModal($productId, $variantId = null)
    {
        $this->selectedProduct = \App\Models\Product::find($productId);
        $this->selectedVariant = $variantId ? \App\Models\ProductVariant::find($variantId) : null;
        $this->isOrderModalOpen = true;
    }

    public function closeOrderModal()
    {
        $this->isOrderModalOpen = false;
        $this->resetValidation();
        // keep input fields to avoid frustrating the user
    }

    public function submitOrder()
    {
        $executed = RateLimiter::attempt(
            'submit-order:' . request()->ip(),
            $maxAttempts = 3,
            function() {
                $this->validate();

                $request = \App\Models\EventRequest::create([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'email' => $this->email,
                    'telefono' => $this->telefono,
                    'direccion_evento' => $this->direccion_evento,
                    'fecha_evento' => $this->fecha_evento,
                    'hora_evento' => $this->hora_evento,
                    'cantidad_invitados' => $this->cantidad_invitados,
                    'observaciones_cliente' => $this->observaciones_cliente,
                    'product_id' => $this->selectedProduct->id ?? null,
                    'product_variant_id' => $this->selectedVariant->id ?? null,
                    'estado' => \App\Enums\EventRequestStatus::Nuevo,
                ]);

                $this->isOrderModalOpen = false;
                $this->reset(['nombre', 'apellido', 'email', 'telefono', 'direccion_evento', 'fecha_evento', 'hora_evento', 'cantidad_invitados', 'observaciones_cliente', 'selectedProduct', 'selectedVariant']);
                
                $this->dispatch('order-submitted');
            },
            $decaySeconds = 300 // 5 minutes
        );

        if (! $executed) {
            throw ValidationException::withMessages([
                'email' => 'Demasiados intentos. Por favor, intente de nuevo en unos minutos.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.home-page')->layout('components.layouts.app');
    }
}
