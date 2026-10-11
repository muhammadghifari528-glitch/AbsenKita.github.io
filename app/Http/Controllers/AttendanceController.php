<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
class AttendanceController extends Controller
{
    public function create() { return view('attendance.create', ['events' => Event::where('is_active', true)->orderBy('event_date')->get()]); }
    public function store(Request $request)
    {
        $data = $request->validate(['event_id' => ['required','exists:events,id'], 'participant_number' => ['required','string','max:50'], 'name' => ['required','string','max:150'], 'status' => ['required','in:hadir,izin,sakit']]);
        $participant = Participant::where('participant_number', $data['participant_number'])->whereRaw('LOWER(name) = ?', [strtolower($data['name'])])->first();
        if (! $participant) return back()->withErrors(['participant_number' => 'Nomor peserta dan nama tidak cocok.'])->withInput();
        if (! Event::whereKey($data['event_id'])->where('is_active', true)->exists()) return back()->withErrors(['event_id' => 'Kegiatan tidak tersedia.'])->withInput();
        try { Attendance::create(['event_id' => $data['event_id'], 'participant_id' => $participant->id, 'status' => $data['status'], 'attended_at' => now()]); }
        catch (QueryException $e) { return back()->withErrors(['participant_number' => 'Anda sudah mengisi absensi untuk kegiatan ini.'])->withInput(); }
        return redirect()->route('attendance.create')->with('success', 'Absensi berhasil disimpan. Terima kasih!');
    }
}
