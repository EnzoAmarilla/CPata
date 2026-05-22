<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Ajuste')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('key')
                            ->label('Clave')
                            ->required()->maxLength(100)->unique(ignoreRecord: true),
                        \Filament\Forms\Components\Select::make('type')
                            ->label('Tipo de dato')
                            ->options([
                                'string' => 'Texto',
                                'text' => 'Texto Largo',
                                'boolean' => 'Sí / No',
                                'json' => 'JSON',
                            ])->required()->default('string')->reactive(),
                        \Filament\Forms\Components\TextInput::make('value')
                            ->label('Valor')
                            ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => in_array($get('type'), ['text', 'boolean', 'json'])),
                        \Filament\Forms\Components\Textarea::make('value')
                            ->label('Valor')
                            ->rows(3)
                            ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('type') !== 'text'),
                        \Filament\Forms\Components\Toggle::make('value')
                            ->label('Valor (Activo/Inactivo)')
                            ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('type') !== 'boolean'),
                        \Filament\Forms\Components\Textarea::make('value')
                            ->label('Valor (JSON)')
                            ->rows(5)
                            ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('type') !== 'json'),
                        \Filament\Forms\Components\TextInput::make('group')
                            ->label('Grupo')
                            ->default('general')
                            ->maxLength(50),
                    ]),
            ]);
    }
}
