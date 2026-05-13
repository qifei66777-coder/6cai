<?php

namespace App\Filament\Resources\DrawScheduleResource\Pages;

use App\Filament\Resources\DrawScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDrawSchedule extends CreateRecord
{
    protected static string $resource = DrawScheduleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
