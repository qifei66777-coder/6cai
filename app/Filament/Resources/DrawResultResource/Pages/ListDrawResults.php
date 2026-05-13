<?php

namespace App\Filament\Resources\DrawResultResource\Pages;

use App\Filament\Resources\DrawResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDrawResults extends ListRecords
{
    protected static string $resource = DrawResultResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('新增开奖记录')];
    }
}
