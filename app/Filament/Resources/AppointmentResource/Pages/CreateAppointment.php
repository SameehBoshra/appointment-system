<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\AppointmentCreatedNotification;
use Illuminate\Support\Facades\Notification;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;


protected function afterCreate(): void
{
    $appointment = $this->record;

    $provider = $appointment->provider; // Or use Provider::find($appointment->provider_id);
    if ($provider) {
        $provider->notify(new AppointmentCreatedNotification($appointment));
    }
}
}
