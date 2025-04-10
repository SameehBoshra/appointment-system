<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // ✅ Add this line

class Provider extends Model
{
    use HasFactory, Notifiable; // ✅ This is fine too

    protected $guarded = [];
    public $timestamps = true;

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
