<?php

namespace App\Filament\Resources\StatementofAccountResource\Pages;

use App\Filament\Resources\StatementofAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatementofAccounts extends ListRecords
{
    protected static string $resource = StatementofAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
