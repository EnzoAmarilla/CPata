<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('group')->label('Grupo')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('key')->label('Clave')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('value')->label('Valor')->limit(50),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('group')
                    ->label('Grupo')
                    ->options(fn () => \App\Models\Setting::pluck('group', 'group')->unique()->toArray()),
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
