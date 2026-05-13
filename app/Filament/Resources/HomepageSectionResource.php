<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Models\HomepageSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static \UnitEnum|string|null $navigationGroup = '系统设置';
    protected static ?string $navigationLabel = '首页装修';
    protected static ?string $modelLabel = '首页模块';
    protected static ?string $pluralModelLabel = '首页模块配置';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('section_key')
                ->label('模块类型')
                ->options([
                    'draw'    => '开奖展示模块',
                    'posts'   => '帖子列表模块',
                    'gallery' => '图片展示模块',
                ])
                ->required()
                ->disabledOn('edit'),

            TextInput::make('title')
                ->label('前端显示标题（可空）')
                ->maxLength(50)
                ->helperText('留空则使用默认标题'),

            Toggle::make('is_enabled')
                ->label('是否启用')
                ->default(true),

            TextInput::make('sort_order')
                ->label('排序值（越小越靠前）')
                ->numeric()
                ->default(10)
                ->required(),

            TextInput::make('display_limit')
                ->label('展示数量（帖子/图片模块）')
                ->numeric()
                ->nullable()
                ->helperText('留空不限制'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_key')
                    ->label('模块')
                    ->formatStateUsing(fn($state) => match($state) {
                        'draw'    => '开奖展示模块',
                        'posts'   => '帖子列表模块',
                        'gallery' => '图片展示模块',
                        default   => $state,
                    })
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'draw'    => 'success',
                        'posts'   => 'info',
                        'gallery' => 'warning',
                        default   => 'gray',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('前端标题')
                    ->default('（默认）'),

                Tables\Columns\IconColumn::make('is_enabled')
                    ->label('启用')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序值')
                    ->sortable(),

                Tables\Columns\TextColumn::make('display_limit')
                    ->label('展示数量')
                    ->default('不限'),
            ])
            ->actions([
                EditAction::make()->label('编辑'),
                Action::make('toggle_enabled')
                    ->label(fn(HomepageSection $record) => $record->is_enabled ? '关闭' : '开启')
                    ->icon('heroicon-o-power')
                    ->action(fn(HomepageSection $record) => $record->update(['is_enabled' => !$record->is_enabled])),
            ])
            ->defaultSort('sort_order', 'asc')
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHomepageSections::route('/'),
            'create' => Pages\CreateHomepageSection::route('/create'),
            'edit'   => Pages\EditHomepageSection::route('/{record}/edit'),
        ];
    }
}
