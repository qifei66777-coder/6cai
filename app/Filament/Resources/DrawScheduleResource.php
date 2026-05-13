<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrawScheduleResource\Pages;
use App\Models\DrawSchedule;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class DrawScheduleResource extends Resource
{
    protected static ?string $model = DrawSchedule::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clock';
    protected static \UnitEnum|string|null $navigationGroup = '开奖管理';
    protected static ?string $navigationLabel = '开奖排期设置';
    protected static ?string $modelLabel = '排期设置';
    protected static ?string $pluralModelLabel = '排期设置';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('type')
                ->label('开奖类型')
                ->options(['store' => '澳彩', 'online' => '港彩'])
                ->required()
                ->disabledOn('edit'),

            TextInput::make('type_label')
                ->label('类型名称')
                ->required()
                ->maxLength(20),

            CheckboxList::make('default_weekdays')
                ->label('默认开奖星期（多选）')
                ->options([
                    '1'=>'周一','2'=>'周二','3'=>'周三',
                    '4'=>'周四','5'=>'周五','6'=>'周六','7'=>'周日',
                ])
                ->dehydrateStateUsing(fn($state) => implode(',', $state ?? []))
                ->afterStateHydrated(function ($component, $state) {
                    if (is_string($state)) {
                        $component->state(array_filter(explode(',', $state)));
                    }
                })
                ->columns(4),

            TimePicker::make('default_time')
                ->label('默认开奖时间')
                ->seconds(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('type_label')->label('类型'),
            Tables\Columns\TextColumn::make('default_weekdays')->label('默认星期'),
            Tables\Columns\TextColumn::make('default_time')->label('默认时间'),
        ])
        ->actions([EditAction::make()->label('编辑')])
        ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDrawSchedules::route('/'),
            'create' => Pages\CreateDrawSchedule::route('/create'),
            'edit'   => Pages\EditDrawSchedule::route('/{record}/edit'),
        ];
    }
}
