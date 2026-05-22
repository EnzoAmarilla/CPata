<?php

namespace App\Filament\Resources\EventRequests\Pages;

use App\Filament\Resources\EventRequests\EventRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\EventRequestStatus;
use App\Models\EventRequest;

class ListEventRequests extends ListRecords
{
    protected static string $resource = EventRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        try {
            app(\App\Services\GoogleCalendarService::class)->syncAllEvents();
        } catch (\Exception $e) {
            // Silently fail if Google API is unreachable during load
        }
    }

    public function getTabs(): array
    {
        return [
            'todos' => Tab::make('Todos'),
            'nuevos' => Tab::make('Nuevos')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', EventRequestStatus::Nuevo))
                ->badge(EventRequest::where('estado', EventRequestStatus::Nuevo)->count())
                ->badgeColor('info'),
            'pendientes' => Tab::make('Pendientes (En proceso)')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('estado', [EventRequestStatus::Contactado, EventRequestStatus::PendienteSeña])),
            'confirmados' => Tab::make('Confirmados')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', EventRequestStatus::Confirmado)),
        ];
    }
}
