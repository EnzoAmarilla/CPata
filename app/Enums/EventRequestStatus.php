<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EventRequestStatus: string implements HasLabel, HasColor, HasIcon
{
    case Nuevo            = 'nuevo';
    case Contactado       = 'contactado';
    case PendienteSeña    = 'pendiente_sena';
    case Confirmado       = 'confirmado';
    case Cancelado        = 'cancelado';
    case Entregado        = 'entregado';

    public function getLabel(): string
    {
        return match($this) {
            self::Nuevo         => 'Nuevo',
            self::Contactado    => 'Contactado',
            self::PendienteSeña => 'Pendiente de Seña',
            self::Confirmado    => 'Confirmado',
            self::Cancelado     => 'Cancelado',
            self::Entregado     => 'Entregado',
        };
    }

    public function getColor(): string|array|null
    {
        return match($this) {
            self::Nuevo         => 'info',
            self::Contactado    => 'warning',
            self::PendienteSeña => 'warning',
            self::Confirmado    => 'success',
            self::Cancelado     => 'danger',
            self::Entregado     => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match($this) {
            self::Nuevo         => 'heroicon-m-star',
            self::Contactado    => 'heroicon-m-phone',
            self::PendienteSeña => 'heroicon-m-banknotes',
            self::Confirmado    => 'heroicon-m-check-circle',
            self::Cancelado     => 'heroicon-m-x-circle',
            self::Entregado     => 'heroicon-m-truck',
        };
    }
}
