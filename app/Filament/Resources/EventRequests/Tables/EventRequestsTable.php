<?php

namespace App\Filament\Resources\EventRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Table;

class EventRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->columns([
                \Filament\Tables\Columns\Layout\Panel::make([
                    \Filament\Tables\Columns\Layout\Stack::make([
                        \Filament\Tables\Columns\Layout\Split::make([
                            \Filament\Tables\Columns\TextColumn::make('nombre_completo')
                                ->searchable(['nombre', 'apellido'])
                                ->sortable(['nombre'])
                                ->weight('bold')
                                ->size(\Filament\Support\Enums\TextSize::Large),
                            \Filament\Tables\Columns\TextColumn::make('estado')
                                ->badge()
                                ->sortable()
                                ->alignEnd(),
                        ]),
                        \Filament\Tables\Columns\Layout\Stack::make([
                            \Filament\Tables\Columns\TextColumn::make('product.name')
                                ->icon('heroicon-m-shopping-bag')
                                ->color('gray')
                                ->searchable(),
                            \Filament\Tables\Columns\TextColumn::make('variant.label')
                                ->icon('heroicon-m-tag')
                                ->color('gray'),
                            \Filament\Tables\Columns\TextColumn::make('fecha_y_hora')
                                ->getStateUsing(fn (\App\Models\EventRequest $record) => 
                                    \Carbon\Carbon::parse($record->fecha_evento)->format('d/m/Y') . ' - ' . 
                                    \Carbon\Carbon::parse($record->hora_evento)->format('H:i') . ' hs'
                                )
                                ->icon('heroicon-m-calendar')
                                ->color('primary')
                                ->weight('bold')
                                ->sortable(['fecha_evento']),
                            \Filament\Tables\Columns\TextColumn::make('calendar_status')
                                ->getStateUsing(fn (\App\Models\EventRequest $record) => $record->google_calendar_event_id ? 'En Calendar' : 'Sin agendar')
                                ->badge()
                                ->color(fn (\App\Models\EventRequest $record) => $record->google_calendar_event_id ? 'success' : 'gray')
                                ->icon('heroicon-m-calendar-days'),
                            \Filament\Tables\Columns\TextColumn::make('cantidad_invitados')
                                ->numeric()
                                ->icon('heroicon-m-users')
                                ->color('gray')
                                ->sortable()
                                ->formatStateUsing(fn ($state) => $state . ' invitados'),
                            \Filament\Tables\Columns\TextColumn::make('telefono')
                                ->icon('heroicon-m-phone')
                                ->color('gray')
                                ->searchable()
                                ->copyable(),
                            \Filament\Tables\Columns\TextColumn::make('created_at')
                                ->since()
                                ->icon('heroicon-m-clock')
                                ->color('gray')
                                ->size(\Filament\Support\Enums\TextSize::ExtraSmall)
                                ->sortable(),
                        ])->space(2)->extraAttributes(['class' => 'mt-4']),
                    ])->space(3)
                ])
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options(\App\Enums\EventRequestStatus::class),
                \Filament\Tables\Filters\SelectFilter::make('product_id')
                    ->label('Producto')
                    ->relationship('product', 'name'),
                \Filament\Tables\Filters\Filter::make('fecha_evento')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('desde')->label('Fecha desde'),
                        \Filament\Forms\Components\DatePicker::make('hasta')->label('Fecha hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['desde'], fn ($q) => $q->whereDate('fecha_evento', '>=', $data['desde']))
                            ->when($data['hasta'], fn ($q) => $q->whereDate('fecha_evento', '<=', $data['hasta']));
                    }),
            ])
            ->actions([
                EditAction::make()->iconButton()->tooltip('Ver / Editar')->color('primary'),
                Action::make('imprimir_pedido')
                    ->iconButton()
                    ->icon('heroicon-m-printer')
                    ->color('warning')
                    ->url(fn (\App\Models\EventRequest $record) => route('admin.orders.print', $record))
                    ->openUrlInNewTab()
                    ->tooltip('Imprimir Pedido'),
                Action::make('whatsapp')
                    ->iconButton()
                    ->icon('heroicon-m-chat-bubble-oval-left')
                    ->color('success')
                    ->url(fn (\App\Models\EventRequest $record) => $record->whats_app_link)
                    ->openUrlInNewTab()
                    ->tooltip('Abrir chat en WhatsApp'),
                Action::make('confirmar_agendar')
                    ->iconButton()
                    ->icon('heroicon-m-calendar-days')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalWidth(\Filament\Support\Enums\Width::Small)
                    ->modalHeading('¿Confirmar y agendar en Google Calendar?')
                    ->modalDescription('Esta acción cambiará el estado a "Confirmado" y creará el evento en Google Calendar.')
                    ->hidden(fn (\App\Models\EventRequest $record) => $record->estado === \App\Enums\EventRequestStatus::Confirmado)
                    ->tooltip('Confirmar y Agendar')
                    ->action(function (\App\Models\EventRequest $record) {
                        try {
                            $service = app(\App\Services\GoogleCalendarService::class);
                            $eventId = $service->createEventFromRequest($record);

                            $record->update([
                                'estado'                   => \App\Enums\EventRequestStatus::Confirmado,
                                'google_calendar_event_id' => $eventId,
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('✅ Pedido confirmado y agendado')
                                ->body("Evento creado en Google Calendar para {$record->nombre_completo}")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('❌ Error al agendar')
                                ->body('No se pudo crear el evento: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('cambiar_estado')
                    ->iconButton()
                    ->icon('heroicon-m-arrow-path')
                    ->color('gray')
                    ->tooltip('Cambiar Estado')
                    ->modalWidth(\Filament\Support\Enums\Width::ExtraSmall)
                    ->form([
                        \Filament\Forms\Components\Select::make('estado')
                            ->label('Nuevo estado')
                            ->options(\App\Enums\EventRequestStatus::class)
                            ->required(),
                    ])
                    ->action(function (\App\Models\EventRequest $record, array $data) {
                        $record->update(['estado' => $data['estado']]);
                        \Filament\Notifications\Notification::make()
                            ->title('Estado actualizado')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('marcar_contactado')
                        ->label('Marcar como Contactado')
                        ->icon('heroicon-m-phone')
                        ->action(fn ($records) => $records->each->update(['estado' => \App\Enums\EventRequestStatus::Contactado]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
