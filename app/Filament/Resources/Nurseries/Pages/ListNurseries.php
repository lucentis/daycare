<?php

namespace App\Filament\Resources\Nurseries\Pages;

use App\Filament\Resources\Nurseries\NurseryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNurseries extends ListRecords
{
    protected static string $resource = NurseryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
