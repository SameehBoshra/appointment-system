<?php
namespace App\Repositories\AppointmentRepository;
use App\Models\Appointment;

class AppointmentRepository implements Interfaces\IAppointmentRepository
{
    public function getAllAppointments()
    {
        return Appointment::all();
    }

    public function getAppointmentById($id)
    {
        return Appointment::find($id);
    }

    public function createAppointment(array $data)
    {
        return Appointment::create($data);
    }

    public function updateAppointment($id, array $data)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->update($data);
            return $appointment;
        }
        return null;
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete();
            return true;
        }
        return false;
    }
}