<?php

namespace App\Models;

use App\Enums\EventRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion_evento',
        'fecha_evento',
        'hora_evento',
        'cantidad_invitados',
        'product_id',
        'product_variant_id',
        'estado',
        'observaciones_cliente',
        'observaciones_admin',
        'google_calendar_event_id',
        'ip_address',
    ];

    protected $casts = [
        'estado'             => EventRequestStatus::class,
        'fecha_evento'       => 'date',
        'cantidad_invitados' => 'integer',
    ];

    /**
     * Get the full name of the client.
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * The product associated with this request.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The specific variant chosen.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Check if this request has been synced to Google Calendar.
     */
    public function isOnCalendar(): bool
    {
        return !is_null($this->google_calendar_event_id);
    }

    /**
     * Generate a pre-filled WhatsApp link for this request.
     */
    public function getWhatsAppLinkAttribute(): string
    {
        // Strip non-numeric characters from the client's phone number
        $number = preg_replace('/[^0-9]/', '', $this->telefono);
        $product = $this->product?->name ?? 'el producto';
        $variant = $this->variant?->label ?? '';
        $fecha = $this->fecha_evento?->format('d/m/Y') ?? '';

        $message = urlencode(
            "Hola {$this->nombre}!\n" .
            "Te contactamos de Cpata por tu consulta sobre *{$product}* ({$variant}) para el *{$fecha}*.\n" .
            "¿Podemos coordinar los detalles?"
        );

        return "https://wa.me/{$number}?text={$message}";
    }
}
