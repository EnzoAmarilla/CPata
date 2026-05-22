<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información General')
                    ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre del Producto')
                            ->required()->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, $state) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()->unique(ignoreRecord: true)->maxLength(200),
                        \Filament\Forms\Components\Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'name')
                            ->searchable()->preload()->required(),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Orden')
                            ->numeric()->default(0),
                        \Filament\Forms\Components\Toggle::make('active')
                            ->label('Activo')
                            ->default(true),
                        \Filament\Forms\Components\Toggle::make('featured')
                            ->label('Destacado')
                            ->default(false),
                        \Filament\Forms\Components\Textarea::make('short_description')
                            ->label('Descripción Corta')
                            ->rows(2)->maxLength(500)->columnSpanFull(),
                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción Completa')
                            ->columnSpanFull()
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'undo', 'redo']),
                    ]),

                \Filament\Schemas\Components\Section::make('Imágenes del Producto')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('images')
                            ->label('Imágenes')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->maxFiles(5)
                            ->panelLayout('grid')
                            ->disk('public')
                            ->directory('products')
                            ->maxSize(5120),
                    ]),

                \Filament\Schemas\Components\Section::make('Variantes')
                    ->icon('heroicon-m-adjustments-horizontal')
                    ->description('Agregá las variantes por cantidad de personas o tamaño.')
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('variants')
                            ->label('')
                            ->relationship()
                            ->columnSpanFull()
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('label')
                                    ->label('Etiqueta')
                                    ->placeholder('ej: 20 personas')
                                    ->required()->maxLength(100),
                                \Filament\Forms\Components\TextInput::make('persons')
                                    ->label('Personas estimadas')
                                    ->numeric()->nullable(),
                                \Filament\Forms\Components\TextInput::make('weight_kg')
                                    ->label('Peso (kg)')
                                    ->numeric()->nullable(),
                                \Filament\Forms\Components\TextInput::make('price')
                                    ->label('Precio (ARS)')
                                    ->numeric()->required()->prefix('$'),
                                \Filament\Forms\Components\Textarea::make('description')
                                    ->label('Descripción detallada (Salsas, panes, etc.)')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->nullable(),
                                \Filament\Forms\Components\TextInput::make('order')
                                    ->label('Orden')
                                    ->numeric()->default(0),
                                \Filament\Forms\Components\Toggle::make('active')
                                    ->label('Activa')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn ($state) => $state['label'] ?? 'Nueva variante'),
                    ]),
            ]);
    }
}
