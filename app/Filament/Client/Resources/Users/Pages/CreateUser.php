<?php

namespace App\Filament\Client\Resources\Users\Pages;

use App\Filament\Client\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
