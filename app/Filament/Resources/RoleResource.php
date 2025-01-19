<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Company;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Roles & Permissions';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Role Name')
                    ->helperText('The name of the role, eg "Admin"')
                    ->maxLength(255),
                Forms\Components\CheckboxList::make('permissions')
                    ->label('Permissions')
                    ->columnSpanFull()
                    ->options([
                        'view_users' => 'View Users',
                        'create_users' => 'Create Users',
                        'edit_users' => 'Edit Users',
                        'delete_users' => 'Delete Users',
                        'view_roles' => 'View Roles',
                        'create_roles' => 'Create Roles',
                        'edit_roles' => 'Edit Roles',
                        'delete_roles' => 'Delete Roles',
                        'view_permissions' => 'View Permissions',
                        'assign_permissions' => 'Assign Permissions',
                        'manage_settings' => 'Manage Settings',
                    ])
                    ->helperText('Select the permissions assigned to this role.')
                    ->bulkToggleable()
                    ->searchable()
                    ->columns(4),
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->helperText('The company this role belongs to.')
                    ->options(Company::all()->pluck('name', 'id'))
                    ->searchable()
            ]);
    }
    // https://filamentphp.com/docs/3.x/forms/fields/checkbox-list use this 
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permissions')
                    ->searchable(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
