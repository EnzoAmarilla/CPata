<?php

namespace App\Filament\Resources\EventRequests\Schemas;

use Filament\Schemas\Schema;

class EventRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información del Cliente')
                    ->icon('heroicon-m-user')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()->maxLength(100),
                        \Filament\Forms\Components\TextInput::make('apellido')
                            ->label('Apellido')
                            ->required()->maxLength(100),
                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()->required(),
                        \Filament\Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()->required(),
                    ]),

                \Filament\Schemas\Components\Section::make('Detalles del Evento')
                    ->icon('heroicon-m-map-pin')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('direccion_evento')
                            ->label('Dirección del Evento')
                            ->required()->columnSpanFull(),
                        \Filament\Forms\Components\DatePicker::make('fecha_evento')
                            ->label('Fecha del Evento')
                            ->required()->native(false),
                        \Filament\Forms\Components\TimePicker::make('hora_evento')
                            ->label('Hora del Evento')
                            ->required()->seconds(false),
                        \Filament\Forms\Components\TextInput::make('cantidad_invitados')
                            ->label('Cantidad de Invitados')
                            ->numeric()->required()->minValue(1),
                        \Filament\Forms\Components\Select::make('product_id')
                            ->label('Producto')
                            ->relationship('product', 'name')
                            ->searchable()->preload()
                            ->reactive()
                            ->afterStateUpdated(fn ($set) => $set('product_variant_id', null)),
                        \Filament\Forms\Components\Select::make('product_variant_id')
                            ->label('Variante')
                            ->relationship('variant', 'label')
                            ->options(function (\Filament\Schemas\Components\Utilities\Get $get) {
                                $productId = $get('product_id');
                                if (!$productId) return [];
                                return \App\Models\ProductVariant::where('product_id', $productId)
                                    ->where('active', true)
                                    ->orderBy('order')
                                    ->pluck('label', 'id');
                            })
                            ->searchable(),
                    ]),

                \Filament\Schemas\Components\Section::make('Observaciones')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->columns(1)
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('observaciones_cliente')
                            ->label('Observaciones del Cliente')
                            ->rows(3)->disabled(),
                        \Filament\Forms\Components\Textarea::make('observaciones_admin')
                            ->label('Notas internas (Admin)')
                            ->rows(3)->helperText('Solo visible para el equipo de Cpata.'),
                    ]),

                \Filament\Schemas\Components\Section::make('Estado del Pedido')
                    ->icon('heroicon-m-arrow-path')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options(\App\Enums\EventRequestStatus::class)
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('google_calendar_event_id')
                            ->label('ID Evento Google Calendar')
                            ->disabled()
                            ->helperText('Se completa automáticamente al confirmar y agendar.'),
                    ]),
            ]);
    }
}
