<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'event_date', 'location', 'is_active'];
    protected $casts = ['event_date' => 'date', 'is_active' => 'boolean'];

    public function attendances() { return $this->hasMany(Attendance::class); }
}
