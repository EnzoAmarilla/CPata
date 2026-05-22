<?php

namespace App\Filament\Resources\EventRequests\Pages;

use App\Filament\Resources\EventRequests\EventRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventRequest extends CreateRecord
{
    protected static string $resource = EventRequestResource::class;
}
