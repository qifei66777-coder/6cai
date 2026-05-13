<?php

namespace App\Filament\Resources\DrawResultResource\Pages;

use App\Filament\Resources\DrawResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrawResult extends EditRecord
{
    protected static string $resource = DrawResultResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()->label('删除')];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
