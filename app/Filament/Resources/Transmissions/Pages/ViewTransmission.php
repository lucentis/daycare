<?php

namespace App\Filament\Resources\Transmissions\Pages;

use App\Filament\Resources\Transmissions\TransmissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransmission extends ViewRecord
{
    protected static string $resource = TransmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
