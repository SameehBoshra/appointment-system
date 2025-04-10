<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Providers';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Doctor')
                    ->description('Data Provider Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->label('Name Of Doctor')
                        ->required()
                        ->maxLength(255)
                        ->minLength(3),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->minLength(5)
                        ->unique(Provider::class, 'email', ignoreRecord: true),
                    Forms\Components\TextInput::make('specialization')
                        ->label('Specialization')
                        ->required()
                        ->maxLength(255)
                        ->minLength(3),
                    ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                ->label('Name Of Doctor')
                ->sortable()
                ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('specialization')
                    ->label('Specialization')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
