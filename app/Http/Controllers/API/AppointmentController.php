<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Repositories\AppointmentRepository\AppointmentRepository;
use Illuminate\Http\Request;
use App\Notifications\AppointmentCreatedNotification;
class AppointmentController extends Controller
{
    protected $appointment_Repository;
    public function __construct(AppointmentRepository $appointment_Repository)
    {
        return $this->appointment_Repository = $appointment_Repository;
    }
    public function index()
    {
        $appointments = $this->appointment_Repository->getAllAppointments();
        return response()->json([
            'status' => true,
            'Appointments ' => $appointments
        ], 200);
    }
    public function show($id)
    {
        $appointment = $this->appointment_Repository->getAppointmentById($id);
        if ($appointment) {
            return response()->json([
                'status' => true,
                'Appointment' => $appointment
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|min:5|max:255',
        'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/|unique:appointments,phone',
        'dob' => 'required|date',
        'provider_id' => 'required|integer',
        'date' => 'required|date',
        'time' => 'required|string',
        'status' => 'required|string'
    ]);
    $doctor=Provider::find($request->provider_id);
    if (!$doctor) {
        return response()->json(['message' => 'Doctor not found'], 404);
    }
    // Create the appointment first
    $appointment = $this->appointment_Repository->createAppointment($data);

    $provider = Provider::find($appointment->provider_id);

    if ($provider) {
        $provider->notify(new AppointmentCreatedNotification($appointment));
    }

    return response()->json([
        'status' => true,
        'Appointment' => $appointment,
        'message' => 'Appointment created and email sent to doctor.'
    ], 201);
}

    public function destroy($id)
    {
        $deleted = $this->appointment_Repository->deleteAppointment($id);
        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Appointment deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/|unique:appointments,phone,' . $id,
            'dob' => 'required|date',
            'provider_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|string'
        ]);
        $appointment = $this->appointment_Repository->updateAppointment($id, $data);

        if ($appointment) {
            return response()->json([
                'status' => true,
                'Appointment' => $appointment
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found'
            ], 404);
        }
    }

}
