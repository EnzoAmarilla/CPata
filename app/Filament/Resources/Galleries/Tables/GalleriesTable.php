<?php

namespace App\Filament\Resources\Galleries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image_path')->label('Imagen')->square(),
                \Filament\Tables\Columns\TextColumn::make('caption')->label('Pie de foto')->searchable(),
                \Filament\Tables\Columns\IconColumn::make('active')->label('Visible')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('order')->label('Orden')->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('active')->label('Visible'),
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
