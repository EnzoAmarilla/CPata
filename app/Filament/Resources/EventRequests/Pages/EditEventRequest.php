<?php

namespace App\Filament\Resources\EventRequests\Pages;

use App\Filament\Resources\EventRequests\EventRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventRequest extends EditRecord
{
    protected static string $resource = EventRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
