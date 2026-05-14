<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class SiteSettingsPage extends Page
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static \UnitEnum|string|null $navigationGroup = '系统设置';
    protected static ?string $navigationLabel = '网站设置';
    protected static ?string $title = '网站设置';
    protected static ?int $navigationSort = 20;
    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'marquee_text' => SiteSetting::get('marquee_text'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Textarea::make('marquee_text')
                    ->label('跑马灯公告文字')
                    ->helperText('显示在首页顶部的滚动公告，留空则不显示')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::set('marquee_text', $this->data['marquee_text'] ?? null);

        Notification::make()
            ->title('保存成功')
            ->success()
            ->send();
    }
}
