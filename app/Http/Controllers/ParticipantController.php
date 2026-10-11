<?php
namespace App\Http\Controllers;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ParticipantController extends Controller
{
    public function index(Request $request) { $search = $request->string('q')->trim(); $participants = Participant::when($search, fn($q) => $q->where(fn($q) => $q->where('name','like',"%$search%")->orWhere('participant_number','like',"%$search%")))->latest()->paginate(12)->withQueryString(); return view('admin.participants.index', compact('participants','search')); }
    public function create() { return view('admin.participants.form', ['participant' => new Participant]); }
    public function store(Request $request) { Participant::create($this->validated($request)); return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil ditambahkan.'); }
    public function edit(Participant $participant) { return view('admin.participants.form', compact('participant')); }
    public function update(Request $request, Participant $participant) { $participant->update($this->validated($request, $participant)); return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil diperbarui.'); }
    public function destroy(Participant $participant) { $participant->delete(); return back()->with('success', 'Peserta berhasil dihapus.'); }
    private function validated(Request $request, ?Participant $participant = null) { return $request->validate(['participant_number' => ['required','string','max:50', Rule::unique('participants')->ignore($participant)], 'name' => ['required','string','max:150'], 'phone' => ['nullable','string','max:30'], 'address' => ['nullable','string','max:1000']]); }
}
