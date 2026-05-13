<?php

namespace App\Filament\Resources\DrawResultResource\Pages;

use App\Filament\Resources\DrawResultResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDrawResult extends CreateRecord
{
    protected static string $resource = DrawResultResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
