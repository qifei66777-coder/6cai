<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoLinkResource\Pages;
use App\Models\PromoLink;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables;
use Filament\Tables\Table;

class PromoLinkResource extends Resource
{
    protected static ?string $model = PromoLink::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-link';
    protected static \UnitEnum|string|null $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = '推广链接';
    protected static ?string $modelLabel = '推广链接';
    protected static ?string $pluralModelLabel = '推广链接';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title')
                ->label('标题')
                ->required()
                ->maxLength(50),

            TextInput::make('description')
                ->label('描述（副标题）')
                ->maxLength(100),

            TextInput::make('url')
                ->label('跳转链接')
                ->required()
                ->url()
                ->maxLength(255),

            TextInput::make('button_text')
                ->label('按钮文字')
                ->default('立即查看')
                ->maxLength(20),

            TextInput::make('sort_order')
                ->label('排序')
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
                Tables\Columns\TextColumn::make('title')->label('标题'),
                Tables\Columns\TextColumn::make('description')->label('描述')->default('—'),
                Tables\Columns\TextColumn::make('url')->label('链接')->limit(40),
                Tables\Columns\TextColumn::make('button_text')->label('按钮'),
                Tables\Columns\TextColumn::make('sort_order')->label('排序')->sortable(),
                Tables\Columns\IconColumn::make('is_enabled')->label('启用')->boolean(),
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
            'index'  => Pages\ListPromoLinks::route('/'),
            'create' => Pages\CreatePromoLink::route('/create'),
            'edit'   => Pages\EditPromoLink::route('/{record}/edit'),
        ];
    }
}
