<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Widgets\UserStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class
ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsWidget::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
