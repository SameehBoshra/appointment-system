<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\AppointmentCreatedNotification;
class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'date' => 'date',
        'dob' => 'date',
        'time' => 'datetime',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

}
