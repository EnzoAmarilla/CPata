<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('images')
                    ->label('Imágenes')
                    ->stacked()
                    ->circular()
                    ->limit(3)
                    ->disk('public'),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()->sortable()->weight('bold'),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->badge()->color('primary'),
                \Filament\Tables\Columns\TextColumn::make('variants_count')
                    ->label('Variantes')
                    ->counts('variants')
                    ->badge()->color('gray'),
                \Filament\Tables\Columns\IconColumn::make('featured')
                    ->label('Destacado')
                    ->boolean(),
                \Filament\Tables\Columns\IconColumn::make('active')
                    ->label('Activo')
                    ->boolean(),
                \Filament\Tables\Columns\TextColumn::make('order')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name'),
                \Filament\Tables\Filters\TernaryFilter::make('active')->label('Activo'),
                \Filament\Tables\Filters\TernaryFilter::make('featured')->label('Destacado'),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
    }
}
