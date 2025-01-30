<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')->badge(\App\Models\User::count()),
        ];

        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended',
        ];

        foreach ($statuses as $status => $label) {
            $tabs[$status] = Tab::make($label)
                ->badge(\App\Models\User::where('status', $status)->count())
                ->modifyQueryUsing(function ($query) use ($status) {
                    return $query->where('status', $status);
                });
        }

        return $tabs;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
