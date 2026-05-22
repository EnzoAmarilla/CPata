<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información del Testimonio')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('client_name')
                            ->label('Nombre del Cliente')
                            ->required()->maxLength(150),
                        \Filament\Forms\Components\Select::make('rating')
                            ->label('Calificación')
                            ->options([
                                1 => '⭐ 1 Estrella',
                                2 => '⭐⭐ 2 Estrellas',
                                3 => '⭐⭐⭐ 3 Estrellas',
                                4 => '⭐⭐⭐⭐ 4 Estrellas',
                                5 => '⭐⭐⭐⭐⭐ 5 Estrellas',
                            ])->default(5)->required(),
                        \Filament\Forms\Components\Textarea::make('content')
                            ->label('Comentario')
                            ->rows(4)->required(),
                        \Filament\Forms\Components\Toggle::make('active')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
