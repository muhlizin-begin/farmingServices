<?php

namespace App\Filament\Resources\Teams;

use App\Filament\Resources\Teams\Pages\ManageTeams;
use App\Models\Team;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class TeamResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Harvest Management';
    protected static ?string $model = Team::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::HomeModern;

    protected static ?string $recordTitleAttribute = 'Team';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_regu')
                    ->label('Nama Regu')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_kabag')
                    ->label('Nama Kabag')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_kasie')
                    ->label('Nama kasie')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_mandor1')
                    ->label('mandor 1')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_mandor2')
                    ->label('mandor 2')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Team')
            ->columns([
                TextColumn::make('id_regu')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('nama_regu')
                    ->label('Regu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_kabag')
                    ->label('Kabag')
                    ->searchable()
                    ->sortable()
                    ->default(fn ($record) => $record?->nama_kabag),
                TextColumn::make('nama_kasie')
                    ->label('Kasie')
                    ->searchable()
                    ->sortable()
                    ->default(fn ($record) => $record?->nama_kasie),
                TextColumn::make('nama_mandor1')
                    ->label('Mandor 1')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_mandor2')
                    ->label('Mandor 2')
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
            ->defaultSort('id_regu', direction: 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTeams::route('/'),
        ];
    }
}
