<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use App\Models\Industry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The full registered name of the company.'),
                Forms\Components\Select::make('industry_id')
                    ->label('Industry')
                    ->options(Industry::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('business_address.line_1')
                    ->label('Address Line 1')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('business_address.line_2')
                    ->label('Address Line 2')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Optional'),
                Forms\Components\TextInput::make('business_address.city')
                    ->label('City')
                    ->maxLength(100)
                    ->required(),
                Forms\Components\TextInput::make('business_address.state')
                    ->label('State')
                    ->maxLength(100)
                    ->required(),
                Forms\Components\TextInput::make('business_address.postal_code')
                    ->label('Postal Code')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\TextInput::make('business_address.country')
                    ->label('Country')
                    ->maxLength(100)
                    ->required(),
                Forms\Components\TextInput::make('registration_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('country_of_registration')
                    ->maxLength(255),
                Forms\Components\TextInput::make('registration_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'inactive' => 'Inactive',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                    ])
                    ->native(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('industry')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country_of_registration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
