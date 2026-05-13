<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';
    protected static \UnitEnum|string|null $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = '图片管理';
    protected static ?string $modelLabel = '图片';
    protected static ?string $pluralModelLabel = '图片列表';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image_path')
                ->label('上传图片')
                ->image()
                ->disk('public')
                ->directory('gallery')
                ->required()
                ->maxSize(10240)
                ->columnSpanFull(),

            TextInput::make('title')
                ->label('图片标题（可选）')
                ->maxLength(100),

            Textarea::make('description')
                ->label('图片说明（可选）')
                ->rows(2)
                ->maxLength(300),

            TextInput::make('link_url')
                ->label('点击跳转链接（可选）')
                ->url()
                ->maxLength(255),

            Toggle::make('is_visible')
                ->label('是否显示')
                ->default(true),

            TextInput::make('sort_order')
                ->label('排序值（越小越靠前）')
                ->numeric()
                ->default(0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('预览')
                    ->disk('public')
                    ->height(60)
                    ->width(90),

                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->default('（无标题）')
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('显示')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序')
                    ->sortable(),

                Tables\Columns\TextColumn::make('link_url')
                    ->label('跳转链接')
                    ->limit(30)
                    ->default('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible')->label('显示状态'),
            ])
            ->actions([
                EditAction::make()->label('编辑'),
                Action::make('toggle_visible')
                    ->label(fn(GalleryImage $record) => $record->is_visible ? '隐藏' : '显示')
                    ->icon('heroicon-o-eye')
                    ->action(fn(GalleryImage $record) => $record->update(['is_visible' => !$record->is_visible])),
                DeleteAction::make()->label('删除'),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit'   => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}
