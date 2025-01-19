<?php

namespace App\Filament\Resources\StatementofAccountResource\Pages;

use App\Filament\Resources\StatementofAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatementofAccount extends EditRecord
{
    protected static string $resource = StatementofAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
