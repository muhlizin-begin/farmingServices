<?php

namespace App\Filament\Resources\Harvestings\Pages;

use App\Filament\Resources\Harvestings\HarvestingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHarvestings extends ManageRecords
{
    protected static string $resource = HarvestingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
