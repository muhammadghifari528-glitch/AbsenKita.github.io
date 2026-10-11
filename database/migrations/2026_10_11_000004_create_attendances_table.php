<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('attendances', function (Blueprint $table) { $table->id(); $table->foreignId('event_id')->constrained()->cascadeOnDelete(); $table->foreignId('participant_id')->constrained()->cascadeOnDelete(); $table->enum('status', ['hadir', 'izin', 'sakit']); $table->timestamp('attended_at'); $table->timestamps(); $table->unique(['event_id', 'participant_id']); }); } public function down() { Schema::dropIfExists('attendances'); } };
