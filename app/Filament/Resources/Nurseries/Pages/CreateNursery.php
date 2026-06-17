<?php

namespace App\Filament\Resources\Nurseries\Pages;

use App\Enums\NurseryUserRole;
use App\Filament\Resources\Nurseries\NurseryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNursery extends CreateRecord
{
    protected static string $resource = NurseryResource::class;

    protected function afterCreate(): void
    {
        if (auth()->user()->hasRole('client')) {
            $this->record->users()->attach(auth()->id(), [
                'role' => NurseryUserRole::Client->value,
            ]);
        }
    }
}
