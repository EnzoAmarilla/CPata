<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('icon')->label(''),
                \Filament\Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('products_count')->counts('products')->label('Productos'),
                \Filament\Tables\Columns\IconColumn::make('active')->label('Activa')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('order')->label('Orden')->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('active')->label('Activa'),
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
