<?php

namespace App\Filament\Resources\DrawScheduleResource\Pages;

use App\Filament\Resources\DrawScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDrawSchedules extends ListRecords
{
    protected static string $resource = DrawScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('新增排期')];
    }
}
