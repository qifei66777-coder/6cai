<?php

namespace App\Filament\Resources\PromoLinkResource\Pages;

use App\Filament\Resources\PromoLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPromoLinks extends ListRecords
{
    protected static string $resource = PromoLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('新增推广链接')];
    }
}
