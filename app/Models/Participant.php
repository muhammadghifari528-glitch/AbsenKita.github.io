<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['participant_number', 'name', 'phone', 'address'];

    public function attendances() { return $this->hasMany(Attendance::class); }
}
