<?php

namespace App\Filament\Resources\Transmissions\Pages;

use App\Filament\Resources\Transmissions\TransmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransmission extends EditRecord
{
    protected static string $resource = TransmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
