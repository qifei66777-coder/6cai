<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrawResultResource\Pages;
use App\Models\DrawResult;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class DrawResultResource extends Resource
{
    protected static ?string $model = DrawResult::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-trophy';
    protected static \UnitEnum|string|null $navigationGroup = '开奖管理';
    protected static ?string $navigationLabel = '开奖记录';
    protected static ?string $modelLabel = '开奖记录';
    protected static ?string $pluralModelLabel = '开奖记录';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('基础信息')->schema([
                Select::make('type')
                    ->label('开奖类型')
                    ->options(['store' => '澳彩', 'online' => '港彩'])
                    ->required()
                    ->default('store')
                    ->live(),

                TextInput::make('issue_number')
                    ->label('期数')
                    ->required()
                    ->maxLength(20),

                Forms\Components\DatePicker::make('draw_date')
                    ->label('开奖日期')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, \Filament\Schemas\Components\Utilities\Set $set) {
                        if ($state) {
                            $weekdays = ['','周一','周二','周三','周四','周五','周六','周日'];
                            $dow = \Carbon\Carbon::parse($state)->dayOfWeekIso;
                            $set('weekday_display', $weekdays[$dow] ?? '');
                        }
                    }),

                Placeholder::make('weekday_display')
                    ->label('星期几（自动识别）')
                    ->content(fn($record) => $record?->getWeekdayLabel() ?? '选择日期后自动显示'),

                TimePicker::make('draw_time')
                    ->label('开奖时间')
                    ->required()
                    ->seconds(false),

                Select::make('status')
                    ->label('开奖状态')
                    ->options(['pending'=>'待开奖','drawing'=>'正在开奖','completed'=>'已开奖'])
                    ->required()
                    ->default('pending'),

                Toggle::make('is_published')
                    ->label('是否发布')
                    ->default(false),

                Toggle::make('is_home_featured')
                    ->label('首页展示（同类型唯一）')
                    ->default(false),

                TextInput::make('history_url')
                    ->label('历史记录链接（可选）')
                    ->url()
                    ->maxLength(255),
            ])->columns(2),

            Section::make('普通号码配置')->schema([
                Repeater::make('drawNumbers')
                    ->relationship()
                    ->label('普通号码')
                    ->schema([
                        TextInput::make('number')
                            ->label('号码')
                            ->required()
                            ->maxLength(4)
                            ->columnSpan(1),
                        Select::make('color')
                            ->label('颜色')
                            ->options(['red'=>'红色','blue'=>'蓝色','green'=>'绿色'])
                            ->required()
                            ->default('blue')
                            ->columnSpan(1),
                        TextInput::make('label')
                            ->label('下方标签（可选）')
                            ->maxLength(20)
                            ->columnSpan(1),
                        Hidden::make('sort_order')
                            ->default(0),
                    ])
                    ->columns(3)
                    ->addActionLabel('+ 添加号码')
                    ->reorderable('sort_order')
                    ->collapsible()
                    ->defaultItems(0),
            ]),

            Section::make('特别号码配置')->schema([
                TextInput::make('special_number')
                    ->label('特别号码')
                    ->maxLength(4),
                Select::make('special_color')
                    ->label('特别号码颜色')
                    ->options(['red'=>'红色','blue'=>'蓝色','green'=>'绿色'])
                    ->default('red'),
                TextInput::make('special_label')
                    ->label('特别号码下方标签（可选）')
                    ->maxLength(20),
            ])->columns(3),

            Section::make('开奖视频')->schema([
                FileUpload::make('video_file')
                    ->label('上传视频文件')
                    ->disk('public')
                    ->directory('videos')
                    ->acceptedFileTypes(['video/mp4','video/quicktime','video/mpeg'])
                    ->maxSize(204800)
                    ->helperText('支持 MP4 / MOV，最大 200MB'),
                TextInput::make('video_url')
                    ->label('外链视频地址（可选）')
                    ->url()
                    ->helperText('有上传文件时优先播放文件'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('类型')
                    ->formatStateUsing(fn($state) => match($state) {
                        'store'  => '澳彩',
                        'online' => '港彩',
                        default  => $state,
                    })
                    ->badge()
                    ->color(fn($state) => $state === 'store' ? 'success' : 'info'),

                Tables\Columns\TextColumn::make('issue_number')
                    ->label('期数')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('draw_date')
                    ->label('开奖日期')
                    ->date('Y-m-d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('draw_time')
                    ->label('开奖时间'),

                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->formatStateUsing(fn($state) => match($state) {
                        'pending'   => '待开奖',
                        'drawing'   => '正在开奖',
                        'completed' => '已开奖',
                        default     => $state,
                    })
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pending'   => 'warning',
                        'drawing'   => 'danger',
                        'completed' => 'success',
                        default     => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('已发布')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_home_featured')
                    ->label('首页展示')
                    ->boolean(),

                Tables\Columns\IconColumn::make('video_file')
                    ->label('有视频')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->video_file) || !empty($record->video_url)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('开奖类型')
                    ->options(['store'=>'澳彩','online'=>'港彩']),
                Tables\Filters\SelectFilter::make('status')
                    ->label('状态')
                    ->options(['pending'=>'待开奖','drawing'=>'正在开奖','completed'=>'已开奖']),
            ])
            ->actions([
                EditAction::make()->label('编辑'),
                Action::make('set_featured')
                    ->label('设为首页展示')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->action(fn(DrawResult $record) => $record->update(['is_home_featured' => true]))
                    ->visible(fn(DrawResult $record) => !$record->is_home_featured),
                Action::make('toggle_publish')
                    ->label(fn(DrawResult $record) => $record->is_published ? '下架' : '上架')
                    ->icon('heroicon-o-arrow-up-circle')
                    ->action(fn(DrawResult $record) => $record->update(['is_published' => !$record->is_published])),
                DeleteAction::make()->label('删除'),
            ])
            ->defaultSort('draw_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDrawResults::route('/'),
            'create' => Pages\CreateDrawResult::route('/create'),
            'edit'   => Pages\EditDrawResult::route('/{record}/edit'),
        ];
    }
}
