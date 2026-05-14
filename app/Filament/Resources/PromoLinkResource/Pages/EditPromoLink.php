<?php

namespace App\Filament\Resources\PromoLinkResource\Pages;

use App\Filament\Resources\PromoLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPromoLink extends EditRecord
{
    protected static string $resource = PromoLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->label('删除')];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
