<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static \UnitEnum|string|null $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = '帖子管理';
    protected static ?string $modelLabel = '帖子';
    protected static ?string $pluralModelLabel = '帖子列表';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('帖子信息')->schema([
                TextInput::make('title')
                    ->label('帖子标题')
                    ->required()
                    ->maxLength(200)
                    ->columnSpanFull(),

                Select::make('tag')
                    ->label('分类标签')
                    ->options([
                        ''         => '无',
                        '开奖资讯' => '开奖资讯',
                        '号码分析' => '号码分析',
                        '生肖解读' => '生肖解读',
                        '走势图表' => '走势图表',
                        '技巧心得' => '技巧心得',
                        '特别公告' => '特别公告',
                        '置顶'     => '置顶',
                    ])
                    ->default('')
                    ->nullable(),

                FileUpload::make('cover_image')
                    ->label('封面图（可选）')
                    ->image()
                    ->disk('public')
                    ->directory('post-covers')
                    ->maxSize(5120),

                Textarea::make('excerpt')
                    ->label('摘要（可选）')
                    ->rows(2)
                    ->maxLength(300)
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('正文内容')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('post-images')
                    ->toolbarButtons([
                        'attachFiles','blockquote','bold','bulletList',
                        'codeBlock','h2','h3','italic','link',
                        'orderedList','redo','strike','underline','undo',
                    ])
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('发布设置')->schema([
                Toggle::make('is_published')
                    ->label('是否发布')
                    ->default(false),

                Toggle::make('is_pinned')
                    ->label('是否置顶')
                    ->default(false),

                TextInput::make('sort_order')
                    ->label('排序值（越小越靠前）')
                    ->numeric()
                    ->default(0),

                DateTimePicker::make('published_at')
                    ->label('发布时间')
                    ->nullable(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('封面')
                    ->disk('public')
                    ->height(40)
                    ->width(60),

                Tables\Columns\TextColumn::make('tag')
                    ->label('标签')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        '置顶' => 'success',
                        '公告' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('已发布')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('置顶')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('发布时间')
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('发布状态'),
                Tables\Filters\TernaryFilter::make('is_pinned')->label('置顶'),
            ])
            ->actions([
                EditAction::make()->label('编辑'),
                Action::make('toggle_publish')
                    ->label(fn(Post $record) => $record->is_published ? '下架' : '发布')
                    ->icon('heroicon-o-arrow-up-circle')
                    ->action(fn(Post $record) => $record->update(['is_published' => !$record->is_published])),
                DeleteAction::make()->label('删除'),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
