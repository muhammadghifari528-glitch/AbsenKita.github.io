<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Event;
use App\Models\Participant;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_public_attendance_can_be_recorded_only_once_per_event()
    {
        $event = Event::create(['name' => 'Rapat Warga', 'event_date' => now()->toDateString(), 'is_active' => true]);
        $participant = Participant::create(['participant_number' => 'P-001', 'name' => 'Budi Santoso']);
        $payload = ['event_id' => $event->id, 'participant_number' => $participant->participant_number, 'name' => $participant->name, 'status' => 'hadir'];
        $this->get(route('attendance.create'))->assertOk()->assertSee('Isi Absensi');
        $this->post(route('attendance.store'), $payload)->assertRedirect(route('attendance.create'));
        $this->assertDatabaseHas('attendances', ['event_id' => $event->id, 'participant_id' => $participant->id, 'status' => 'hadir']);
        $this->from(route('attendance.create'))->post(route('attendance.store'), $payload)->assertSessionHasErrors('participant_number');
    }

    public function test_admin_pages_require_login_and_admin_can_export_report()
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.reports.export'))->assertOk()->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
