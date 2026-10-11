<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'participant_id', 'status', 'attended_at'];
    protected $casts = ['attended_at' => 'datetime'];

    public function event() { return $this->belongsTo(Event::class); }
    public function participant() { return $this->belongsTo(Participant::class); }
}
