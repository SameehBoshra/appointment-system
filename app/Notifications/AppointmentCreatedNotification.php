<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;

class AppointmentCreatedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Determine how the notification should be sent.
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast']; // Add 'database' if you want to store it too
    }

    /**
     * Define the mail representation.
     */
    public function toMail($notifiable)
    {
        // Format inside your toMail() method:
$formattedDate = Carbon::parse($this->appointment->date)->format('F j, Y'); // e.g., April 9, 2025
$formattedTime = Carbon::parse($this->appointment->time)->format('g:i A');   // e.g., 2:30 PM

        return (new MailMessage)
            ->subject('New Appointment Booked')
            ->greeting("Hello Dr. {$this->appointment->provider->name}")
            ->line("A new appointment has been scheduled.")
            ->line("Patient: {$this->appointment->name}")
            ->line("Date: {$formattedDate}")
            ->line("Time:  {$formattedTime}")
            ->line("Please check your dashboard for more details.");
    }

    /**
     * Define the broadcast representation.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'appointment_id' => $this->appointment->id,
            'provider_id' => $this->appointment->provider_id,
            'patient_name' => $this->appointment->name,
            'date' => $this->appointment->date,
            'time' => $this->appointment->time,
        ]);
    }

    /**
     * Define the private channel for broadcasting.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.Provider.' . $this->appointment->provider_id);
    }

    /**
     * Define a custom event name for the broadcast.
     */
    public function broadcastAs()
    {
        return 'appointment.created';
    }

    /**
     * Optional: Define the array form of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'provider_id' => $this->appointment->provider_id,
            'patient_name' => $this->appointment->name,
            'date' => $this->appointment->date,
            'time' => $this->appointment->time,
        ];
    }
}
