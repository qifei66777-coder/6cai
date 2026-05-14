<?php

namespace App\Filament\Resources\PromoLinkResource\Pages;

use App\Filament\Resources\PromoLinkResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePromoLink extends CreateRecord
{
    protected static string $resource = PromoLinkResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
