<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Admin', User::count())
            ->descriptionIcon('heroicon-o-user',IconPosition::Before)
            ->description('Total number of Admin')
            ->chart([7, 30, 3, 40, 4, 60])
            ->color('info'),

            Stat::make('Doctor', Provider::count())
            ->descriptionIcon('heroicon-o-user-circle',IconPosition::Before)
            ->description('Total number of doctors')
            ->chart([7, 15, 50, 3, 15, 70, 17])
            ->color('success'),

            Stat::make('Appointment', Appointment::count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->description('Total number of Appointments')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('primary'),

            Stat::make('Patient Has Appointment ', Appointment::where('status','pending')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([2, 50, 10, 3, 60, 4, 17])
            ->color('info'),

            Stat::make('Patients Meet Doctors ', Appointment::where('status','confirmed')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([2, 50, 10, 3, 60, 4, 17])
            ->color('info'),

            Stat::make('Patient cancelled Appointment ', Appointment::where('status','cancelled')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([90, 50, 10, 50, 60, 4, 17])
            ->color('warning'),


        ];
    }
}
