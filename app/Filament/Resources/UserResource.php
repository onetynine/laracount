<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3) // Define a 3-column grid
                    ->schema([
                        // Left column with larger fields
                        Forms\Components\Grid::make(1) // Full-width within this column
                            ->columnSpan(2)
                            ->columns(4) // Occupy two-thirds of the grid
                            ->schema([
                                Forms\Components\Fieldset::make('Login Info')
                                    ->schema([

                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('password')
                                            ->password()
                                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                            ->dehydrated(fn(?string $state): bool => filled($state))
                                            ->required(fn(string $operation): bool => $operation === 'create')
                                    ])
                                    ->columns(2),

                                Forms\Components\Fieldset::make('Label')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('company_id')
                                            ->label('Company')
                                            ->options(Company::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->reactive() // Enable reactivity to detect changes
                                            ->afterStateUpdated(function (callable $set) {
                                                // Clear the role_id field when company_id changes
                                                $set('role_id', null);
                                            })
                                            ->required()
                                            ->columnSpan(4),

                                        // Forms\Components\Select::make('role_id')
                                        //     ->label('Role')
                                        //     ->options(function (callable $get) {
                                        //         $companyId = $get('company_id'); // Get the selected company ID
                                        //         if ($companyId) {
                                        //             // Fetch roles dynamically based on the selected company
                                        //             return \App\Models\Role::where('company_id', $companyId)
                                        //                 ->pluck('name', 'id');
                                        //         }
                                        //         return []; // Return empty options if no company is selected
                                        //     })
                                        //     ->searchable()
                                        //     ->required()->nullable()
                                        //     ->columnSpan(2),
                                    ])
                                    ->columns(6),
                            ]),

                        // Right column with smaller fields
                        Forms\Components\Grid::make(1) // Full-width within this column
                            ->columnSpan(1) // Occupy one-third of the grid
                            ->schema([

                                Forms\Components\Radio::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->descriptions([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'suspended' => 'Suspended',
                                    ])->required()->default('inactive'),

                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'suspended' => 'danger',
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
