<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Pedidos       = 'pedidos';
    case Catalogo      = 'catalogo';
    case Contenido     = 'contenido';
    case Configuracion = 'configuracion';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pedidos       => 'Pedidos',
            self::Catalogo      => 'Catálogo',
            self::Contenido     => 'Contenido',
            self::Configuracion => 'Configuración',
        };
    }
}
