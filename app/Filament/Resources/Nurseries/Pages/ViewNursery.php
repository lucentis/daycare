<?php

namespace App\Filament\Resources\Nurseries\Pages;

use App\Filament\Resources\Nurseries\NurseryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNursery extends ViewRecord
{
    protected static string $resource = NurseryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getContentTabLabel(): ?string
    {
        return 'Crèches';
    }
}
