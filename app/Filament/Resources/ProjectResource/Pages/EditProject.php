<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('show')
                ->label('Show Project')
                ->url(fn($record) => route('project.show', $record))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye')
                ->color('primary'),
        ];
    }

    // On save, clear the cache for the image
    protected function afterSave(): void
    {
        $this->record->forgetImage();
    }
}
