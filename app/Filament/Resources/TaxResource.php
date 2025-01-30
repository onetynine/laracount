<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxResource\Pages;
use App\Filament\Resources\TaxResource\RelationManagers;
use App\Models\Tax;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxResource extends Resource
{
    protected static ?string $model = Tax::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Maintenance';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Label')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'sales_tax' => 'Sales Tax',
                                'vat' => 'Value-Added Tax (VAT)',
                                'gst' => 'Goods and Services Tax (GST)',
                                'corporate_income_tax' => 'Corporate Income Tax',
                                'withholding_tax' => 'Withholding Tax',
                                'payroll_tax' => 'Payroll Tax',
                                'fringe_benefit_tax' => 'Fringe Benefit Tax (FBT)',
                                'property_tax' => 'Property Tax',
                                'capital_gains_tax' => 'Capital Gains Tax',
                                'excise_duty' => 'Excise Duty',
                                'customs_duty' => 'Customs Duty',
                                'environmental_tax' => 'Environmental Tax',
                                'luxury_tax' => 'Luxury Tax',
                                'tourism_tax' => 'Tourism or Hospitality Tax',
                                'carbon_tax' => 'Carbon Tax',
                                'deferred_tax' => 'Deferred Tax',
                                'other' => 'Other',
                            ])
                            ->label('Tax Type')
                            ->searchable() // Allows searching through the options
                            ->placeholder('Select a Tax Type'), // Adds a placeholder

                        Forms\Components\TextInput::make('rate')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->suffix('%')
                            ->maxLength(255),
                        Forms\Components\Select::make('country')
                            ->options([
                                'US' => 'United States',
                                'CA' => 'Canada',
                                'GB' => 'United Kingdom',
                                'AU' => 'Australia',
                                'IN' => 'India',
                                'JP' => 'Japan',
                                'DE' => 'Germany',
                                'FR' => 'France',
                                'IT' => 'Italy',
                                'CN' => 'China',
                                'BR' => 'Brazil',
                                'ZA' => 'South Africa',
                                'MY' => 'Malaysia',
                                // Add more countries as needed
                            ])
                            ->default('MY')
                            ->required()
                            ->searchable(),
                    ])
                    ->columns(4),


                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxes::route('/'),
            'create' => Pages\CreateTax::route('/create'),
            'edit' => Pages\EditTax::route('/{record}/edit'),
        ];
    }
}
