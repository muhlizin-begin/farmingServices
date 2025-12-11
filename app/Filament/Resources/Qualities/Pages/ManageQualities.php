<?php

namespace App\Filament\Resources\Qualities\Pages;

use App\Filament\Resources\Qualities\QualityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageQualities extends ManageRecords
{
    protected static string $resource = QualityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
