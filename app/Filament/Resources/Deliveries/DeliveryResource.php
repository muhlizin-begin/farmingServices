<?php

namespace App\Filament\Resources\Deliveries;

use App\Filament\Resources\Deliveries\Pages\ManageDeliveries;
use App\Models\Delivery;
use App\Models\Location;
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

class DeliveryResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Harvest Management';
    protected static ?string $model = Delivery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Scale;

    protected static ?string $recordTitleAttribute = 'Delivery';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('tanggal_pengiriman')
                //     ->label('Tanggal Pengiriman')
                //     ->required()
                //     ->placeholder('dd-mm-yyyy')
                //     ->reactive()
                //     ->afterStateUpdated(function ($state, callable $set) {
                //         if ($state) {
                //             try {
                //                 $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $state);
                //                 $set('tanggal_pengiriman', $tanggal->format('Y-m-d'));
                //             } catch (\Exception $e) {
                //                 // biarkan kosong jika format salah
                //             }
                //         }
                //     }),
                DatePicker::make('tanggal_pengiriman')
                    ->label('Tanggal Pengiriman')
                    ->required()
                    ->format('Y-m-d')
                    ->displayFormat('d/m/Y')
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
                    ->reactive() // penting
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $lokasi = Location::find($state);
                            if ($lokasi) {
                                $set('status_lokasi', $lokasi->status_lokasi); // otomatis isi status
                            }
                        }
                    }),
                TextInput::make('status_lokasi')
                    ->label('Status')
                    ->required()
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('berat_buah')
                    ->label('Berat Buah (kg)')
                    ->required()
                    ->numeric()
                    ->suffix('kg'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Delivery')
            ->columns([
                TextColumn::make('id_pengiriman')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('tanggal_pengiriman')
                    ->label('Pengiriman')
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
                TextColumn::make('location.status_lokasi')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('berat_buah')
                    ->label('Berat Buah (kg)')
                    ->suffix(' kg')
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
            ])->defaultSort('id_pengiriman', direction: 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDeliveries::route('/'),
        ];
    }
}
