<?php

namespace App\Filament\Resources\Locations;

use App\Filament\Resources\Locations\Pages\ManageLocations;
use App\Models\Location;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LocationResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Harvest Management';
    protected static ?string $model = Location::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cube;

    protected static ?string $recordTitleAttribute = 'Location';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lokasi')
                    ->label('Nama Lokasi')
                    ->required()
                    ->maxLength(255),
                Select::make('status_lokasi')
                    ->label('Status Lokasi')
                    ->options([
                        'NSFC' => 'NSFC',
                        'NSSC' => 'NSSC',
                        'NFSM' => 'NFSM',
                    ])
                    ->required()
                    ->default('NSFC')
                    ->native(false),

                TextInput::make('luas_lokasi')
                    ->label('Luas (Ha)')
                    ->required()
                    ->numeric()
                    ->maxLength(255)
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Location')
            ->columns([
                TextColumn::make('id_lokasi')
                    ->label('No')
                    ->sortable()
                    ->rowIndex(),
                TextColumn::make('nama_lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_lokasi')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('luas_lokasi')
                    ->label('Luas (Ha)')
                    ->searchable()
                    ->sortable(),
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
            ])
            ->defaultSort('id_lokasi', direction: 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLocations::route('/'),
        ];
    }
}
