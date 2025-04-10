<?php

namespace App\Filament\Resources;
use App\Notifications\AppointmentCreatedNotification;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Section;
use App\Mail\AppointmentCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Provider;
class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Appointments';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Patient')
                ->description('Data Patient Details')
                ->schema([
                    TextInput::make('name')
                    ->label('Name Of Patient')
                    ->required()
                    ->maxLength(255)
                    ->minLength(3),
                    TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->minLength(10)
                    ->maxLength(15)
                    ->rule('regex:/^01[0-2,5]{1}[0-9]{8}$/')
                    ->unique(Appointment::class, 'phone', ignoreRecord: true),

                    DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required()
                    ->native(false)
                    ->displayFormat('Y-m-d'),

                ])->columns(3),

                Section::make('Provider')
                ->description('Data Doctor Details')
                ->schema([
                    Select::make('provider_id')
                ->label('Doctor')
                ->relationship('provider', 'name')
                ->searchable()
                ->preload(),
                ])->columns(1),

                Section::make('Appointment')
                ->description('Data Appointment Details')
                ->schema([
                    DatePicker::make('date')
                    ->label('Date Of Appointment')
                    ->required()
                    ->native(false)
                    ->displayFormat('Y-m-d'),

                    TimePicker::make('time')
                    ->label('Time')
                    ->required()
                    ->placeholder('HH:MM')
                    ->seconds(false)
                    ->unique(Appointment::class, 'time', ignoreRecord: true)
                    ->format('H:i'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending')
                    ->reactive()
                    ->searchable(),

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
                ->label('Name Of Patient')
                ->sortable()
                ->searchable(),
                TextColumn::make('phone')
                ->label('Phone')
                ->sortable(),
                TextColumn::make('dob')
                ->label('Date Of Birth')
                ->sortable()
                ->formatStateUsing(fn ($state) => $state->format('d/m/Y')),
                TextColumn::make('provider.name')
                    ->label('Doctor')
                    ->sortable()
                    ->searchable(),
                    TextColumn::make('date')
                    ->label('Date')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => $state->format('d/m/Y')),
                TextColumn::make('time')
                    ->label('Time')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => $state->format('H:i')),
                    TextColumn::make('status')
                    ->label('Status')
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
