<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaction';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form Inputs
                Forms\Components\Section::make('Booking Transaction Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('booking_trx_id')
                            ->required()
                            ->maxLength(255)
                            ->label('Booking transaction id'),

                        Forms\Components\TextInput::make('phone_number')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Booking Price & Schedules')
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),

                        Forms\Components\TextInput::make('duration')
                            ->required()
                            ->numeric()
                            ->prefix('Days'),

                        Forms\Components\DatePicker::make('started_at')
                            ->required(),

                        Forms\Components\DatePicker::make('ended_at')
                            ->required(),

                        Forms\Components\Select::make('is_paid')
                            ->options([
                                true  => 'Paid',
                                false => 'Not Paid'
                            ])
                            ->label('Payment Status')
                            ->required(),

                        Forms\Components\Select::make('office_space_id')
                            ->relationship('officeSpace', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Fetch booking transaction data
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('officeSpace.name'),

                Tables\Columns\TextColumn::make('started_at')
                    ->date()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('primary')
                    ->falseColor('warning')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Payment Status')
                    ->alignCenter(),
            ])
            ->filters([
                // Filter datas
                SelectFilter::make('is_paid')
                    ->options([
                        true  => 'Paid',
                        false => 'Not Paid'
                    ])
                    ->label('Payment Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->label('')
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
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
