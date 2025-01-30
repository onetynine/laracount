<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesOrderResource\Pages;
use App\Filament\Resources\SalesOrderResource\RelationManagers;
use App\Models\SalesOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Tax;
use App\Models\Term;
use App\Models\Product;

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Pre-sales Documents';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Label')
                    ->schema([
                        Forms\Components\Grid::make(3) // Define a 3-column grid
                            ->schema([
                                // Left column with larger fields
                                Forms\Components\Grid::make(1) // Full-width within this column
                                    ->columnSpan(2) // Occupy two-thirds of the grid
                                    ->schema([
                                        Forms\Components\Select::make('company_id')
                                            ->relationship('company', 'name')
                                            ->required()
                                            ->reactive()
                                            ->columnSpanFull()
                                            ->afterStateUpdated(function (callable $set) {
                                                // Reset dependent fields when company changes
                                                $set('customer_id', null);
                                                $set('quotation_id', null);
                                                $set('proforma_invoice_id', null);
                                            }),


                                        Forms\Components\Select::make('customer_id')
                                            ->relationship('customer', 'name')
                                            ->required()
                                            ->label('Customer')->columnSpanFull()
                                            ->searchable(),
                                        Forms\Components\DatePicker::make('issue_date')
                                            ->required()
                                            ->default(now())
                                            ->label('Issue Date'),

                                        Forms\Components\DatePicker::make('due_date')
                                            ->required()
                                            ->label('Due Date'),
                                    ])->columns(2),

                                // Right column with smaller fields
                                Forms\Components\Grid::make(1) // Full-width within this column
                                    ->columnSpan(1) // Occupy one-third of the grid
                                    ->schema([

                                        Forms\Components\Radio::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'kiv' => 'KIV',
                                                'cancelled' => 'Cancelled',
                                                'approved' => 'Approved',
                                            ])
                                            ->default('draft')
                                            ->columnSpan(2)

                                    ]),
                            ]),

                    ]),
                Forms\Components\Fieldset::make('Quotation Details')
                    ->schema([
                        Forms\Components\Repeater::make('products')
                            // ->relationship('products') // Links to the pivot relationship
                            ->label('Products')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->relationship('product', 'name') // References the Product model
                                    ->required()
                                    ->label('Product')
                                    ->reactive()
                                    ->searchable()
                                    ->columnSpan(3)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $set('price', $product->price);
                                            $set('sku', $product->sku);
                                        }
                                    }),

                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->disabled(),

                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->prefix('$')
                                    ->numeric(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $price = $get('price');
                                        if ($price) {
                                            $set('total', $price * $state);
                                        }
                                    }),

                                Forms\Components\TextInput::make('total')
                                    ->label('Total')
                                    ->numeric()
                                    ->prefix('$')
                                    ->disabled(),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->createItemButtonLabel('Add Product')
                            ->columns(7), // Adjust as needed


                        // Tax Selection (Multiple Taxes Per Item)
                        Forms\Components\Select::make('tax_ids')
                            ->label('Taxes')
                            ->options(function (callable $get) {
                                $companyId = $get('company_id');
                                return $companyId ? Tax::where('company_id', $companyId)->pluck('name', 'id') : [];
                            })
                            ->multiple()
                            ->columnSpan(3)
                            ->helperText('Select applicable taxes for this product.'),
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('discount')
                            ->numeric()
                            ->suffix('%'),
                        Forms\Components\TextInput::make('total')
                            ->prefix('$')
                            ->disabled()
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(6),

                Forms\Components\Fieldset::make('Misc')
                    ->schema([
                        Forms\Components\Select::make('term_id')
                            ->label('Terms')
                            ->options(function (callable $get) {
                                $companyId = $get('company_id'); // Get the selected company ID
                                return $companyId ? Term::where('company_id', $companyId)->pluck('title', 'id') : [];
                            })
                            ->searchable()
                            ->reactive()
                            ->required()->columnSpan(2)
                            ->helperText('Select a term associated with the chosen company.'),

                        Forms\Components\Select::make('currency')
                            ->label('Currency')
                            ->options([
                                'RM' => 'Malaysian Ringgit (RM)',
                                'USD' => 'US Dollar (USD)',
                                'EUR' => 'Euro (EUR)',
                                'GBP' => 'British Pound (GBP)',
                            ])
                            ->required()->columnSpan(1)
                            ->default('RM')
                            ->reactive(),
                        // Adjust columns for compact layout
                        Forms\Components\RichEditor::make('note')
                            ->maxLength(255)
                    ])
                    ->columns(3),

            ]); // Allows users to remove items

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_type'),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
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
            'index' => Pages\ListSalesOrders::route('/'),
            'create' => Pages\CreateSalesOrder::route('/create'),
            'edit' => Pages\EditSalesOrder::route('/{record}/edit'),
        ];
    }
}
