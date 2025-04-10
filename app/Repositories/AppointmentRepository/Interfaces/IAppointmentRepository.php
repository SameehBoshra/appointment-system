<?php
namespace App\Repositories\AppointmentRepository\Interfaces;
interface IAppointmentRepository
{
    public function getAllAppointments();
    public function getAppointmentById($id);
    public function createAppointment(array $data);
    public function updateAppointment($id, array $data);
    public function deleteAppointment($id);
}