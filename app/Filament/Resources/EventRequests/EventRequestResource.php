<?php

namespace App\Filament\Resources\EventRequests;

use App\Filament\Resources\EventRequests\Pages\CreateEventRequest;
use App\Filament\Resources\EventRequests\Pages\EditEventRequest;
use App\Filament\Resources\EventRequests\Pages\ListEventRequests;
use App\Filament\Resources\EventRequests\Schemas\EventRequestForm;
use App\Filament\Resources\EventRequests\Tables\EventRequestsTable;
use App\Models\EventRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventRequestResource extends Resource
{
    protected static ?string $model = EventRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string|\UnitEnum|null $navigationGroup = 'Pedidos';
    protected static ?string $modelLabel = 'Pedido';
    protected static ?string $pluralModelLabel = 'Pedidos';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('estado', \App\Enums\EventRequestStatus::Nuevo)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'info';
    }

    public static function form(Schema $schema): Schema
    {
        return EventRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventRequests::route('/'),
            'create' => CreateEventRequest::route('/create'),
            'edit' => EditEventRequest::route('/{record}/edit'),
        ];
    }
}
