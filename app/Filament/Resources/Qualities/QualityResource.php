<?php

namespace App\Filament\Resources\Qualities;

use App\Filament\Resources\Qualities\Pages\ManageQualities;
use App\Models\Location;
use App\Models\Quality;
use App\Models\Team;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class QualityResource extends Resource
{
    protected static ?string $model = Quality::class;
    protected static string | UnitEnum | null $navigationGroup = 'Harvest Management';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'Quality';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal_kwalitas')
                    ->label('Tanggal Kwalitas')
                    ->format('Y-m-d')
                    ->displayFormat('d/m/Y')
                    ->required()
                    ->default(now())
                    ->native(false),

                Select::make('id_regu')
                    ->label('Regu')
                    ->required()
                    ->options(Team::query()->pluck('nama_regu', 'id_regu'))
                    ->searchable(),

                Select::make('id_lokasi')
                    ->label('Lokasi')
                    ->required()
                    ->options(Location::query()->pluck('nama_lokasi', 'id_lokasi'))
                    ->searchable()
                    ->native(false),

                Select::make('bonggol')
                    ->label('Bonggol')
                    ->options([
                        '-' => '0 (-)',
                        '+' => '1 s/d 10 (+)',
                        'x' => '>= 10 (x)',
                    ])
                    ->native(false),

                    Select::make('kememaran')
                    ->label('Kememaran')
                    ->options([
                        'A' => 'Sangat baik (A)',
                        'B' => 'Baik (B)',
                        'C' => 'Buruk (C)',
                    ])
                    ->native(false),

                    Select::make('crown')
                    ->label('Crown')
                    ->options([
                        'A' => 'Sangat baik (A)',
                        'B' => 'Baik (B)',
                        'C' => 'Buruk (C)',
                    ])
                    ->native(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Quality')
            ->columns([
                TextColumn::make('id_kwalitas')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('tanggal_kwalitas')
                    ->label('Tanggal')
                    ->date('d M y')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('team.nama_regu')
                    ->label('Regu')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('location.nama_lokasi')
                    ->label('Lokasi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('bonggol')
                    ->label('Bonggol')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kememaran')
                    ->label('Kememaran')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('crown')
                    ->label('Crown')
                    ->sortable()
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id_kwalitas', direction: 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageQualities::route('/'),
        ];
    }
}
