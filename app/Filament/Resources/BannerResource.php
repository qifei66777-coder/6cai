<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';
    protected static \UnitEnum|string|null $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = 'Banner 轮播';
    protected static ?string $modelLabel = 'Banner';
    protected static ?string $pluralModelLabel = 'Banner 轮播';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image_path')
                ->label('Banner 图片')
                ->disk('public')
                ->directory('banners')
                ->image()
                ->required()
                ->columnSpanFull(),

            TextInput::make('title')
                ->label('标题（可选）')
                ->maxLength(100),

            TextInput::make('link_url')
                ->label('点击跳转链接（可选）')
                ->url()
                ->maxLength(255),

            TextInput::make('sort_order')
                ->label('排序（数字越小越靠前）')
                ->numeric()
                ->default(0),

            Toggle::make('is_enabled')
                ->label('是否启用')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('图片')
                    ->disk('public')
                    ->width(120)
                    ->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->default('—'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_enabled')
                    ->label('启用')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                EditAction::make()->label('编辑'),
                DeleteAction::make()->label('删除'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
