<?php

namespace App\Filament\Resources\Transmissions\Pages;

use App\Filament\Resources\Transmissions\TransmissionResource;
use App\Models\Child;
use Filament\Resources\Pages\CreateRecord;

class CreateTransmission extends CreateRecord
{
    protected static string $resource = TransmissionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nursery_id'] = Child::find($data['child_id'])->nursery->id;
        return $data;
    }
}
