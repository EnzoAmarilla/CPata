<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Imagen de Galería')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->label('Imagen')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('4:3')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600')
                            ->directory('gallery')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('caption')
                            ->label('Pie de foto (opcional)')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                        \Filament\Forms\Components\Toggle::make('active')
                            ->label('Visible')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
