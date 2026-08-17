<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('General Settings')
                    ->columnSpanFull()
                    ->description('Basic store and system settings')
                    ->icon('heroicon-o-building-storefront')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Store Name')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('TechNova E-Commerce')
                                    ->helperText('Your store name displayed everywhere')
                                    ->required(),

                                FileUpload::make('logo')
                                    ->label('Store Logo')
                                    ->image()
                                    ->directory('settings')
                                    ->maxSize(2048)
                                    ->required()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->imageResizeTargetWidth('200')
                                    ->imageResizeTargetHeight('200')
                                    ->helperText('Square logo (max 2MB)'),

                                TextInput::make('email')
                                    ->label('Store Email')
                                    ->email()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->required()
                                    ->placeholder('support@technova.com')
                                    ->helperText('Main contact email'),

                                TextInput::make('phone')
                                    ->label('Store Phone')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->required()
                                    ->placeholder('+977 9800000000')
                                    ->helperText('Contact phone number'),

                                Textarea::make('address')
                                    ->label('Store Address')
                                    ->rows(2)
                                    ->nullable()
                                    ->required()
                                    ->placeholder('Kathmandu, Bagmati Province, Nepal')
                                    ->columnSpanFull(),
                            ]),
                    ]),

               
                Section::make('Payment Settings')
                    ->description('Configure payment methods and currency')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('currency')
                                    ->label('Default Currency')
                                    ->options([
                                        'NPR' => 'NPR (Nepalese Rupee)',
                                        'USD' => 'USD (US Dollar)',
                                        'EUR' => 'EUR (Euro)',
                                        'GBP' => 'GBP (British Pound)',
                                        'INR' => 'INR (Indian Rupee)',
                                    ])
                                    ->default('NPR')
                                    ->nullable(),

                                TextInput::make('currency_symbol')
                                    ->label('Currency Symbol')
                                    ->maxLength(10)
                                    ->nullable()
                                    ->placeholder('Rs.')
                                    ->helperText('Symbol for your currency'),

                                Select::make('payment_gateway')
                                    ->label('Payment Gateway')
                                    ->options([
                                        'esewa' => 'eSewa',
                                        'khalti' => 'Khalti',
                                        'imepay' => 'IME Pay',
                                        'manual' => 'Manual/Offline',
                                    ])
                                    ->nullable()
                                    ->placeholder('Select payment gateway'),
                            ]),
                    ]),

                // ✅ Shipping Settings Section
                Section::make('Shipping Settings')
                    ->description('Configure shipping methods and charges')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('default_shipping_charge')
                                    ->label('Default Shipping Charge')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->placeholder('100.00'),

                                Toggle::make('free_shipping')
                                    ->label('Enable Free Shipping')
                                    ->default(false)
                                    ->helperText('Enable free shipping for orders above threshold'),

                                TextInput::make('free_shipping_threshold')
                                    ->label('Free Shipping Threshold')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->placeholder('1000.00')
                                    ->helperText('Minimum order amount for free shipping'),
                            ]),
                    ]),

                // ✅ Email Settings Section
                Section::make('Email Settings')
                    ->description('Manage email notifications and SMTP settings')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('smtp_host')
                                    ->label('SMTP Host')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('smtp.gmail.com'),

                                TextInput::make('smtp_port')
                                    ->label('SMTP Port')
                                    ->maxLength(10)
                                    ->nullable()
                                    ->placeholder('587'),

                                TextInput::make('smtp_username')
                                    ->label('SMTP Username')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('your-email@gmail.com'),

                                TextInput::make('smtp_password')
                                    ->label('SMTP Password')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->password()
                                    ->placeholder('Enter password'),

                                Select::make('smtp_encryption')
                                    ->label('Encryption')
                                    ->options([
                                        'tls' => 'TLS',
                                        'ssl' => 'SSL',
                                        '' => 'None',
                                    ])
                                    ->nullable()
                                    ->default('tls'),
                            ]),
                    ]),

                // ✅ SEO Settings Section
                Section::make('SEO Settings')
                    ->description('Manage SEO and meta tags')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Default Meta Title')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('TechNova - Best Online Store Nepal'),

                                Textarea::make('meta_description')
                                    ->label('Default Meta Description')
                                    ->rows(2)
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->placeholder('Shop the best products online in Nepal. TechNova offers quality products at best prices.'),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('online store, Nepal, shopping, e-commerce'),
                            ]),
                    ]),

                // Social Media Section
                Section::make('Social Media')
                    ->description('Manage social media links')
                    ->icon('heroicon-o-share')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('facebook')
                                    ->label('Facebook')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('https://facebook.com/technova'),

                                TextInput::make('instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('https://instagram.com/technova'),

                                TextInput::make('twitter')
                                    ->label('Twitter / X')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('https://twitter.com/technova'),

                                TextInput::make('linkedin')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('https://linkedin.com/company/technova'),

                                TextInput::make('youtube')
                                    ->label('YouTube')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('https://youtube.com/@technova'),
                            ]),
                    ]),

                // ✅ Security & Maintenance Section
                Section::make('Security Settings')
                    ->description('Manage security preferences and maintenance')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('maintenance_mode')
                                    ->label('Enable Maintenance Mode')
                                    ->default(false)
                                    ->helperText('When enabled, only admins can access the store'),

                                Textarea::make('maintenance_message')
                                    ->label('Maintenance Message')
                                    ->rows(2)
                                    ->nullable()
                                    ->placeholder('We are currently updating our store. Please check back later.')
                                    ->helperText('Message shown to visitors during maintenance'),
                            ]),
                    ]),

                // ✅ Timezone & Format Section
                Section::make('Timezone & Format')
                    ->description('Configure date, time, and timezone settings')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('timezone')
                                    ->label('Timezone')
                                    ->options([
                                        'Asia/Kathmandu' => 'GMT+05:45 - Kathmandu',
                                        'Asia/Dubai' => 'GMT+04:00 - Dubai',
                                        'Asia/Kolkata' => 'GMT+05:30 - Kolkata',
                                        'Asia/Shanghai' => 'GMT+08:00 - Shanghai',
                                        'Europe/London' => 'GMT+00:00 - London',
                                        'America/New_York' => 'GMT-05:00 - New York',
                                        'America/Los_Angeles' => 'GMT-08:00 - Los Angeles',
                                    ])
                                    ->default('Asia/Kathmandu')
                                    ->nullable(),

                                Select::make('date_format')
                                    ->label('Date Format')
                                    ->options([
                                        'd M, Y' => '31 July, 2025',
                                        'M d, Y' => 'Jul 31, 2025',
                                        'd/m/Y' => '31/07/2025',
                                        'm/d/Y' => '07/31/2025',
                                        'Y-m-d' => '2025-07-31',
                                    ])
                                    ->default('d M, Y')
                                    ->nullable(),

                                Select::make('time_format')
                                    ->label('Time Format')
                                    ->options([
                                        'h:i A' => '10:30 PM',
                                        'H:i' => '22:30',
                                        'h:i:s A' => '10:30:00 PM',
                                        'H:i:s' => '22:30:00',
                                    ])
                                    ->default('h:i A')
                                    ->nullable(),
                            ]),
                    ]),

                // ✅ Other Settings Section
                Section::make('Other Settings')
                    ->description('Miscellaneous settings')
                    ->icon('heroicon-o-ellipsis-horizontal')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('copyright')
                                    ->label('Copyright Text')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('© 2024 TechNova. All rights reserved.'),

                                TextInput::make('footer_text')
                                    ->label('Footer Text')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('Powered by TechNova'),
                            ]),
                    ]),
            ]);
    }
}
