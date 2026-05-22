<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $nuevos = \App\Models\EventRequest::where('estado', \App\Enums\EventRequestStatus::Nuevo)->count();
        $mesActual = \App\Models\EventRequest::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $proximos = \App\Models\EventRequest::where('estado', \App\Enums\EventRequestStatus::Confirmado)
            ->where('fecha_evento', '>=', now())
            ->count();

        return [
            Stat::make('Pedidos Nuevos', $nuevos)
                ->description('Sin revisar')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($nuevos > 0 ? 'warning' : 'gray'),
            Stat::make('Pedidos este mes', $mesActual)
                ->description('Recibidos en ' . now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Próximos Eventos', $proximos)
                ->description('Eventos confirmados por venir')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
        ];
    }
}
