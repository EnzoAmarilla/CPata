<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, $state) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()->unique(ignoreRecord: true)->maxLength(255),
                        \Filament\Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('icon')
                            ->label('Icono (Emoji)')
                            ->maxLength(10),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Orden')
                            ->numeric()->default(0),
                        \Filament\Forms\Components\Toggle::make('active')
                            ->label('Activa')
                            ->default(true),
                    ]),
            ]);
    }
}
