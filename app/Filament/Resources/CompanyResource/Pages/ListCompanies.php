<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')->badge(\App\Models\Company::count()),
        ];

        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended',
        ];

        foreach ($statuses as $status => $label) {
            $tabs[$status] = Tab::make($label)
                ->badge(\App\Models\Company::where('status', $status)->count())
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
