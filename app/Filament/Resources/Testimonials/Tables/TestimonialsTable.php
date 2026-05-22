<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('client_name')->label('Cliente')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('rating')->label('Estrellas')->numeric()->sortable(),
                \Filament\Tables\Columns\IconColumn::make('active')->label('Activo')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('created_at')->label('Fecha')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('active')->label('Activo'),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
