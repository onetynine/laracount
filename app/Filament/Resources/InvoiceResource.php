<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\Quotation;
use App\Models\ProformaInvoice;
use App\Models\Customer;
use App\Models\Tax;
use App\Models\Term;
use App\Models\Product;
// use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationGroup = 'Sales Documents';
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
                                            ->relationship('company', 'name') // Links to the Company model
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
                                            ->label('Customer')
                                            ->options(function (callable $get) {
                                                $companyId = $get('company_id'); // Get the selected company ID

                                                return $companyId
                                                    ? Customer::where('company_id', $companyId)->pluck('name', 'id') // Filter customers by the selected company
                                                    : [];
                                            })
                                            ->searchable()
                                            ->reactive() // Make it reactive to update dynamically
                                            ->required()
                                            ->columnSpanFull(),

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
                                                'active' => 'Active',
                                                'inactive' => 'Inactive',
                                                'suspended' => 'Suspended',
                                            ])
                                            ->descriptions([
                                                'active' => 'Will be selectable in documents',
                                                'inactive' => 'Will NOT be selectable in documents.',
                                                'suspended' => 'Suspended by Laracount'
                                            ])
                                            ->default('active')
                                            ->columnSpan(2)

                                    ]),
                            ]),

                    ]),
                Forms\Components\Fieldset::make('Invoice Details')
                    ->schema([
                        Forms\Components\Repeater::make('products')
                            ->label('Products')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->options(function () {
                                        // Fetch all products without filtering by company_id
                                        return Product::pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->reactive()
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->disabled(),

                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->prefix('$')
                                    ->numeric()
                                    ->disabled()
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive(),

                                Forms\Components\TextInput::make('total')
                                    ->label('Total')
                                    ->numeric()
                                    ->prefix('$')
                                    ->disabled()
                                    ->columnSpan(2),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->createItemButtonLabel('Add Product')
                            ->columns(8), // Adjust as needed
                        // Tax Selection (Multiple Taxes Per Item)
                        Forms\Components\Select::make('tax_id')
                            ->label('Taxes')
                            ->options(function () {
                                return Tax::pluck('code', 'id'); // Fetch all available taxes
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
                            ->options(function () {
                                $user = auth()->user(); // Get the logged-in user
                                $companyId = $user?->company_id; // Get the user's associated company ID

                                return $companyId
                                    ? Term::where('company_id', $companyId)
                                    ->where('type', 'invoice') // Filter by 'invoice' type
                                    ->pluck('title', 'id')
                                    : [];
                            })
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->columnSpan(2)
                            ->helperText('Select a term associated with your company for invoices.'),


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
                            ->columnSpanFull(),

                        Forms\Components\Select::make('quotation_id')
                            ->relationship('quotation', 'id')
                            ->label('Quotation Reference'),

                        Forms\Components\Select::make('proforma_invoice_id')
                            ->relationship('proformaInvoice', 'id')
                            ->label('Proforma Invoice Reference'),
                    ])
                    ->columns(3),

            ]);
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
                Tables\Columns\TextColumn::make('quotation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('proformaInvoice.id')
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
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
