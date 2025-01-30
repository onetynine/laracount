<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages;
use App\Filament\Resources\TermResource\RelationManagers;
use App\Models\Term;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Company;

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Maintenance';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Terms')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'quotation' => 'Quotation',
                                'proforma_invoice' => 'Proforma Invoice',
                                'invoice' => 'Invoice',
                                'sales_order' => 'Sales Order',
                                'credit_note' => 'Credit Note',
                                'debit_note' => 'Debit Note',
                            ]),
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Fieldset::make('Relation')
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label('Company')
                            ->options(Company::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->helpertext('Select which company this term belongs to')
                            ->columnSpan(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('company.name')
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
            'index' => Pages\ListTerms::route('/'),
            'create' => Pages\CreateTerm::route('/create'),
            'edit' => Pages\EditTerm::route('/{record}/edit'),
        ];
    }
}
