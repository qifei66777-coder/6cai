<?php

namespace App\Filament\Resources\DrawScheduleResource\Pages;

use App\Filament\Resources\DrawScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrawSchedule extends EditRecord
{
    protected static string $resource = DrawScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()->label('删除')];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
