<?php

namespace App\Filament\Resources\HostResource\Pages;

use App\Filament\Resources\HostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHost extends EditRecord
{
    protected static string $resource = HostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
