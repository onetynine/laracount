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

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'User Management';

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
                                    ->columnSpan(2)
                                    ->columns(2) // Occupy two-thirds of the grid
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('The full registered name of the company.')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('contact_number')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('industry')
                                            ->label('Industry')
                                            ->options([
                                                'technology' => 'Technology',
                                                'finance' => 'Finance',
                                                'healthcare' => 'Healthcare',
                                                'education' => 'Education',
                                                'retail' => 'Retail',
                                                'manufacturing' => 'Manufacturing',
                                                'hospitality' => 'Hospitality',
                                                'construction' => 'Construction',
                                                'real_estate' => 'Real Estate',
                                                'transportation' => 'Transportation',
                                                'agriculture' => 'Agriculture',
                                                'energy' => 'Energy',
                                                'entertainment' => 'Entertainment',
                                                'others' => 'Others',
                                            ])
                                            ->searchable(),
                                        Forms\Components\TextInput::make('registration_number')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('country_of_registration')
                                            ->required()
                                            ->maxLength(255),


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
                                            ])->required(),

                                    ]),
                            ]),



                    ]),
                Forms\Components\Fieldset::make('Business Address')
                    ->schema([
                        Forms\Components\TextInput::make('business_address.line_1')
                            ->label('Address Line 1')
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('business_address.line_2')
                            ->label('Address Line 2')
                            ->maxLength(255)
                            ->nullable()
                            ->helperText('Optional')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('business_address.city')
                            ->label('City')
                            ->maxLength(100)
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('business_address.postal_code')
                            ->label('Postal Code')
                            ->maxLength(20)
                            ->integer()
                            ->required(),
                        Forms\Components\TextInput::make('business_address.state')
                            ->label('State')
                            ->maxLength(100)
                            ->required(),
                        Forms\Components\Select::make('business_address.country')
                            ->label('Country')
                            ->required()
                            ->searchable()
                            ->options([
                                'AF' => 'Afghanistan',
                                'AL' => 'Albania',
                                'DZ' => 'Algeria',
                                'AS' => 'American Samoa',
                                'AD' => 'Andorra',
                                'AO' => 'Angola',
                                'AG' => 'Antigua and Barbuda',
                                'AR' => 'Argentina',
                                'AM' => 'Armenia',
                                'AU' => 'Australia',
                                'AT' => 'Austria',
                                'AZ' => 'Azerbaijan',
                                'BS' => 'Bahamas',
                                'BH' => 'Bahrain',
                                'BD' => 'Bangladesh',
                                'BB' => 'Barbados',
                                'BY' => 'Belarus',
                                'BE' => 'Belgium',
                                'BZ' => 'Belize',
                                'BJ' => 'Benin',
                                'BT' => 'Bhutan',
                                'BO' => 'Bolivia',
                                'BA' => 'Bosnia and Herzegovina',
                                'BW' => 'Botswana',
                                'BR' => 'Brazil',
                                'BN' => 'Brunei Darussalam',
                                'BG' => 'Bulgaria',
                                'BF' => 'Burkina Faso',
                                'BI' => 'Burundi',
                                'CV' => 'Cabo Verde',
                                'KH' => 'Cambodia',
                                'CM' => 'Cameroon',
                                'CA' => 'Canada',
                                'CF' => 'Central African Republic',
                                'TD' => 'Chad',
                                'CL' => 'Chile',
                                'CN' => 'China',
                                'CO' => 'Colombia',
                                'KM' => 'Comoros',
                                'CG' => 'Congo',
                                'CD' => 'Congo (Democratic Republic)',
                                'CR' => 'Costa Rica',
                                'CI' => 'Côte d\'Ivoire',
                                'HR' => 'Croatia',
                                'CU' => 'Cuba',
                                'CY' => 'Cyprus',
                                'CZ' => 'Czech Republic',
                                'DK' => 'Denmark',
                                'DJ' => 'Djibouti',
                                'DM' => 'Dominica',
                                'DO' => 'Dominican Republic',
                                'EC' => 'Ecuador',
                                'EG' => 'Egypt',
                                'SV' => 'El Salvador',
                                'GQ' => 'Equatorial Guinea',
                                'ER' => 'Eritrea',
                                'EE' => 'Estonia',
                                'SZ' => 'Eswatini',
                                'ET' => 'Ethiopia',
                                'FJ' => 'Fiji',
                                'FI' => 'Finland',
                                'FR' => 'France',
                                'GA' => 'Gabon',
                                'GM' => 'Gambia',
                                'GE' => 'Georgia',
                                'DE' => 'Germany',
                                'GH' => 'Ghana',
                                'GR' => 'Greece',
                                'GD' => 'Grenada',
                                'GT' => 'Guatemala',
                                'GN' => 'Guinea',
                                'GW' => 'Guinea-Bissau',
                                'GY' => 'Guyana',
                                'HT' => 'Haiti',
                                'HN' => 'Honduras',
                                'HU' => 'Hungary',
                                'IS' => 'Iceland',
                                'IN' => 'India',
                                'ID' => 'Indonesia',
                                'IR' => 'Iran',
                                'IQ' => 'Iraq',
                                'IE' => 'Ireland',
                                'IL' => 'Israel',
                                'IT' => 'Italy',
                                'JM' => 'Jamaica',
                                'JP' => 'Japan',
                                'JO' => 'Jordan',
                                'KZ' => 'Kazakhstan',
                                'KE' => 'Kenya',
                                'KI' => 'Kiribati',
                                'KP' => 'Korea (North)',
                                'KR' => 'Korea (South)',
                                'KW' => 'Kuwait',
                                'KG' => 'Kyrgyzstan',
                                'LA' => 'Lao People\'s Democratic Republic',
                                'LV' => 'Latvia',
                                'LB' => 'Lebanon',
                                'LS' => 'Lesotho',
                                'LR' => 'Liberia',
                                'LY' => 'Libya',
                                'LI' => 'Liechtenstein',
                                'LT' => 'Lithuania',
                                'LU' => 'Luxembourg',
                                'MG' => 'Madagascar',
                                'MW' => 'Malawi',
                                'MY' => 'Malaysia',
                                'MV' => 'Maldives',
                                'ML' => 'Mali',
                                'MT' => 'Malta',
                                'MH' => 'Marshall Islands',
                                'MR' => 'Mauritania',
                                'MU' => 'Mauritius',
                                'MX' => 'Mexico',
                                'FM' => 'Micronesia (Federated States of)',
                                'MD' => 'Moldova',
                                'MC' => 'Monaco',
                                'MN' => 'Mongolia',
                                'ME' => 'Montenegro',
                                'MA' => 'Morocco',
                                'MZ' => 'Mozambique',
                                'MM' => 'Myanmar',
                                'NA' => 'Namibia',
                                'NR' => 'Nauru',
                                'NP' => 'Nepal',
                                'NL' => 'Netherlands',
                                'NZ' => 'New Zealand',
                                'NI' => 'Nicaragua',
                                'NE' => 'Niger',
                                'NG' => 'Nigeria',
                                'NO' => 'Norway',
                                'OM' => 'Oman',
                                'PK' => 'Pakistan',
                                'PW' => 'Palau',
                                'PA' => 'Panama',
                                'PG' => 'Papua New Guinea',
                                'PY' => 'Paraguay',
                                'PE' => 'Peru',
                                'PH' => 'Philippines',
                                'PL' => 'Poland',
                                'PT' => 'Portugal',
                                'QA' => 'Qatar',
                                'RO' => 'Romania',
                                'RU' => 'Russian Federation',
                                'RW' => 'Rwanda',
                                'KN' => 'Saint Kitts and Nevis',
                                'LC' => 'Saint Lucia',
                                'VC' => 'Saint Vincent and the Grenadines',
                                'WS' => 'Samoa',
                                'SM' => 'San Marino',
                                'ST' => 'Sao Tome and Principe',
                                'SA' => 'Saudi Arabia',
                                'SN' => 'Senegal',
                                'RS' => 'Serbia',
                                'SC' => 'Seychelles',
                                'SL' => 'Sierra Leone',
                                'SG' => 'Singapore',
                                'SK' => 'Slovakia',
                                'SI' => 'Slovenia',
                                'SB' => 'Solomon Islands',
                                'SO' => 'Somalia',
                                'ZA' => 'South Africa',
                                'ES' => 'Spain',
                                'LK' => 'Sri Lanka',
                                'SD' => 'Sudan',
                                'SR' => 'Suriname',
                                'SE' => 'Sweden',
                                'CH' => 'Switzerland',
                                'SY' => 'Syrian Arab Republic',
                                'TW' => 'Taiwan',
                                'TJ' => 'Tajikistan',
                                'TZ' => 'Tanzania',
                                'TH' => 'Thailand',
                                'TL' => 'Timor-Leste',
                                'TG' => 'Togo',
                                'TO' => 'Tonga',
                                'TT' => 'Trinidad and Tobago',
                                'TN' => 'Tunisia',
                                'TR' => 'Turkey',
                                'TM' => 'Turkmenistan',
                                'TV' => 'Tuvalu',
                                'UG' => 'Uganda',
                                'UA' => 'Ukraine',
                                'AE' => 'United Arab Emirates',
                                'GB' => 'United Kingdom',
                                'US' => 'United States',
                                'UY' => 'Uruguay',
                                'UZ' => 'Uzbekistan',
                                'VU' => 'Vanuatu',
                                'VE' => 'Venezuela',
                                'VN' => 'Viet Nam',
                                'YE' => 'Yemen',
                                'ZM' => 'Zambia',
                                'ZW' => 'Zimbabwe',
                            ])
                            ->columnSpan(2),

                    ])
                    ->columns(6),

                Forms\Components\Fieldset::make('Delivery Address')
                    ->schema([
                        Forms\Components\TextInput::make('delivery_address.line_1')
                            ->label('Address Line 1')
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Contains lot / unit number, building name'),
                        Forms\Components\TextInput::make('delivery_address.line_2')
                            ->label('Address Line 2')
                            ->maxLength(255)
                            ->nullable()
                            ->helperText('Optional')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('delivery_address.city')
                            ->label('City')
                            ->maxLength(100)
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('delivery_address.postal_code')
                            ->label('Postal Code')
                            ->maxLength(20)
                            ->integer()
                            ->required(),
                        Forms\Components\TextInput::make('delivery_address.state')
                            ->label('State')
                            ->maxLength(100)
                            ->required(),
                        Forms\Components\Select::make('delivery_address.country')
                            ->label('Country')
                            ->required()
                            ->searchable()
                            ->options([
                                'AF' => 'Afghanistan',
                                'AL' => 'Albania',
                                'DZ' => 'Algeria',
                                'AS' => 'American Samoa',
                                'AD' => 'Andorra',
                                'AO' => 'Angola',
                                'AG' => 'Antigua and Barbuda',
                                'AR' => 'Argentina',
                                'AM' => 'Armenia',
                                'AU' => 'Australia',
                                'AT' => 'Austria',
                                'AZ' => 'Azerbaijan',
                                'BS' => 'Bahamas',
                                'BH' => 'Bahrain',
                                'BD' => 'Bangladesh',
                                'BB' => 'Barbados',
                                'BY' => 'Belarus',
                                'BE' => 'Belgium',
                                'BZ' => 'Belize',
                                'BJ' => 'Benin',
                                'BT' => 'Bhutan',
                                'BO' => 'Bolivia',
                                'BA' => 'Bosnia and Herzegovina',
                                'BW' => 'Botswana',
                                'BR' => 'Brazil',
                                'BN' => 'Brunei Darussalam',
                                'BG' => 'Bulgaria',
                                'BF' => 'Burkina Faso',
                                'BI' => 'Burundi',
                                'CV' => 'Cabo Verde',
                                'KH' => 'Cambodia',
                                'CM' => 'Cameroon',
                                'CA' => 'Canada',
                                'CF' => 'Central African Republic',
                                'TD' => 'Chad',
                                'CL' => 'Chile',
                                'CN' => 'China',
                                'CO' => 'Colombia',
                                'KM' => 'Comoros',
                                'CG' => 'Congo',
                                'CD' => 'Congo (Democratic Republic)',
                                'CR' => 'Costa Rica',
                                'CI' => 'Côte d\'Ivoire',
                                'HR' => 'Croatia',
                                'CU' => 'Cuba',
                                'CY' => 'Cyprus',
                                'CZ' => 'Czech Republic',
                                'DK' => 'Denmark',
                                'DJ' => 'Djibouti',
                                'DM' => 'Dominica',
                                'DO' => 'Dominican Republic',
                                'EC' => 'Ecuador',
                                'EG' => 'Egypt',
                                'SV' => 'El Salvador',
                                'GQ' => 'Equatorial Guinea',
                                'ER' => 'Eritrea',
                                'EE' => 'Estonia',
                                'SZ' => 'Eswatini',
                                'ET' => 'Ethiopia',
                                'FJ' => 'Fiji',
                                'FI' => 'Finland',
                                'FR' => 'France',
                                'GA' => 'Gabon',
                                'GM' => 'Gambia',
                                'GE' => 'Georgia',
                                'DE' => 'Germany',
                                'GH' => 'Ghana',
                                'GR' => 'Greece',
                                'GD' => 'Grenada',
                                'GT' => 'Guatemala',
                                'GN' => 'Guinea',
                                'GW' => 'Guinea-Bissau',
                                'GY' => 'Guyana',
                                'HT' => 'Haiti',
                                'HN' => 'Honduras',
                                'HU' => 'Hungary',
                                'IS' => 'Iceland',
                                'IN' => 'India',
                                'ID' => 'Indonesia',
                                'IR' => 'Iran',
                                'IQ' => 'Iraq',
                                'IE' => 'Ireland',
                                'IL' => 'Israel',
                                'IT' => 'Italy',
                                'JM' => 'Jamaica',
                                'JP' => 'Japan',
                                'JO' => 'Jordan',
                                'KZ' => 'Kazakhstan',
                                'KE' => 'Kenya',
                                'KI' => 'Kiribati',
                                'KP' => 'Korea (North)',
                                'KR' => 'Korea (South)',
                                'KW' => 'Kuwait',
                                'KG' => 'Kyrgyzstan',
                                'LA' => 'Lao People\'s Democratic Republic',
                                'LV' => 'Latvia',
                                'LB' => 'Lebanon',
                                'LS' => 'Lesotho',
                                'LR' => 'Liberia',
                                'LY' => 'Libya',
                                'LI' => 'Liechtenstein',
                                'LT' => 'Lithuania',
                                'LU' => 'Luxembourg',
                                'MG' => 'Madagascar',
                                'MW' => 'Malawi',
                                'MY' => 'Malaysia',
                                'MV' => 'Maldives',
                                'ML' => 'Mali',
                                'MT' => 'Malta',
                                'MH' => 'Marshall Islands',
                                'MR' => 'Mauritania',
                                'MU' => 'Mauritius',
                                'MX' => 'Mexico',
                                'FM' => 'Micronesia (Federated States of)',
                                'MD' => 'Moldova',
                                'MC' => 'Monaco',
                                'MN' => 'Mongolia',
                                'ME' => 'Montenegro',
                                'MA' => 'Morocco',
                                'MZ' => 'Mozambique',
                                'MM' => 'Myanmar',
                                'NA' => 'Namibia',
                                'NR' => 'Nauru',
                                'NP' => 'Nepal',
                                'NL' => 'Netherlands',
                                'NZ' => 'New Zealand',
                                'NI' => 'Nicaragua',
                                'NE' => 'Niger',
                                'NG' => 'Nigeria',
                                'NO' => 'Norway',
                                'OM' => 'Oman',
                                'PK' => 'Pakistan',
                                'PW' => 'Palau',
                                'PA' => 'Panama',
                                'PG' => 'Papua New Guinea',
                                'PY' => 'Paraguay',
                                'PE' => 'Peru',
                                'PH' => 'Philippines',
                                'PL' => 'Poland',
                                'PT' => 'Portugal',
                                'QA' => 'Qatar',
                                'RO' => 'Romania',
                                'RU' => 'Russian Federation',
                                'RW' => 'Rwanda',
                                'KN' => 'Saint Kitts and Nevis',
                                'LC' => 'Saint Lucia',
                                'VC' => 'Saint Vincent and the Grenadines',
                                'WS' => 'Samoa',
                                'SM' => 'San Marino',
                                'ST' => 'Sao Tome and Principe',
                                'SA' => 'Saudi Arabia',
                                'SN' => 'Senegal',
                                'RS' => 'Serbia',
                                'SC' => 'Seychelles',
                                'SL' => 'Sierra Leone',
                                'SG' => 'Singapore',
                                'SK' => 'Slovakia',
                                'SI' => 'Slovenia',
                                'SB' => 'Solomon Islands',
                                'SO' => 'Somalia',
                                'ZA' => 'South Africa',
                                'ES' => 'Spain',
                                'LK' => 'Sri Lanka',
                                'SD' => 'Sudan',
                                'SR' => 'Suriname',
                                'SE' => 'Sweden',
                                'CH' => 'Switzerland',
                                'SY' => 'Syrian Arab Republic',
                                'TW' => 'Taiwan',
                                'TJ' => 'Tajikistan',
                                'TZ' => 'Tanzania',
                                'TH' => 'Thailand',
                                'TL' => 'Timor-Leste',
                                'TG' => 'Togo',
                                'TO' => 'Tonga',
                                'TT' => 'Trinidad and Tobago',
                                'TN' => 'Tunisia',
                                'TR' => 'Turkey',
                                'TM' => 'Turkmenistan',
                                'TV' => 'Tuvalu',
                                'UG' => 'Uganda',
                                'UA' => 'Ukraine',
                                'AE' => 'United Arab Emirates',
                                'GB' => 'United Kingdom',
                                'US' => 'United States',
                                'UY' => 'Uruguay',
                                'UZ' => 'Uzbekistan',
                                'VU' => 'Vanuatu',
                                'VE' => 'Venezuela',
                                'VN' => 'Viet Nam',
                                'YE' => 'Yemen',
                                'ZM' => 'Zambia',
                                'ZW' => 'Zimbabwe',
                            ])
                            ->columnSpan(2),

                    ])
                    ->columns(6),

                //     Forms\Components\Fieldset::make('Manage Users')
                //         ->schema([
                //             Forms\Components\Repeater::make('users')
                //                 ->relationship('users') // Use the relationship defined in the Company model
                //                 ->label('')
                //                 ->schema([
                //                     Forms\Components\TextInput::make('email')
                //                         ->email()
                //                         ->required()
                //                         ->label('Email')
                //                         ->columnSpan(2), // Takes 2 columns in the row
                //                     Forms\Components\TextInput::make('password')
                //                         ->password()
                //                         ->dehydrateStateUsing(fn($state) => bcrypt($state))
                //                         ->required(fn($record) => !$record)
                //                         ->label('Password')
                //                         ->revealable()
                //                         ->columnSpan(2),
                //                     Forms\Components\TextInput::make('name')
                //                         ->required()
                //                         ->label('User Name')
                //                         ->columnSpan(2),
                //                     Forms\Components\Select::make('role')
                //                         ->options([
                //                             'admin' => 'Admin',
                //                             'staff' => 'Staff',
                //                         ])
                //                         ->required()
                //                         ->label('Role')
                //                         ->columnSpan(1), // Takes 1 column in the row



                //                     Forms\Components\Select::make('status')
                //                         ->options([
                //                             'active' => 'Active',
                //                             'inactive' => 'Inactive',
                //                         ])
                //                         ->required()
                //                         ->label('Status')
                //                         ->columnSpan(1), // Takes 1 column in the row
                //                 ])
                //                 ->columns(4) // Total columns in the Repeater layout
                //                 ->columnSpanFull(), // Make sure the entire Repeater spans full width
                //         ])
                //         ->columns(1) // Ensures the Fieldset layout stays as one column
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('industry')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country_of_registration')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('registration_number')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'suspended' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('User Count')
                    ->counts('users') // Relationship name in the model
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
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('users');
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
