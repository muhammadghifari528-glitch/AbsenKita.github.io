<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
class EventController extends Controller
{
    public function index() { return view('admin.events.index', ['events' => Event::latest('event_date')->paginate(10)]); }
    public function create() { return view('admin.events.form', ['event' => new Event]); }
    public function store(Request $request) { Event::create($this->validated($request)); return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dibuat.'); }
    public function edit(Event $event) { return view('admin.events.form', compact('event')); }
    public function update(Request $request, Event $event) { $event->update($this->validated($request)); return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil diperbarui.'); }
    public function destroy(Event $event) { $event->delete(); return back()->with('success', 'Kegiatan berhasil dihapus.'); }
    private function validated(Request $request) { return $request->validate(['name' => ['required','string','max:150'], 'description' => ['nullable','string'], 'event_date' => ['required','date'], 'location' => ['nullable','string','max:150'], 'is_active' => ['nullable','boolean']]) + ['is_active' => $request->boolean('is_active')]; }
}
