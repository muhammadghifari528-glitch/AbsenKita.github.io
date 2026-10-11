<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Event;
use Illuminate\Http\Request;
class ReportController extends Controller
{
    public function index(Request $request) { [$attendances, $filters] = $this->data($request); return view('admin.reports.index', ['attendances' => $attendances->paginate(30)->withQueryString(), 'events' => Event::orderBy('name')->get(), 'filters' => $filters]); }
    public function export(Request $request) { [$attendances] = $this->data($request); $rows = $attendances->get(); return response()->streamDownload(function () use ($rows) { $out = fopen('php://output', 'w'); fputcsv($out, ['Kegiatan','Tanggal Kegiatan','Nomor Peserta','Nama','Status','Waktu Absensi']); foreach ($rows as $a) fputcsv($out, [$a->event->name, $a->event->event_date->format('Y-m-d'), $a->participant->participant_number, $a->participant->name, ucfirst($a->status), $a->attended_at->format('Y-m-d H:i:s')]); fclose($out); }, 'laporan-absensi.csv', ['Content-Type' => 'text/csv; charset=UTF-8']); }
    private function data(Request $request) { $filters = $request->validate(['event_id' => ['nullable','exists:events,id'], 'date' => ['nullable','date']]); $query = Attendance::with(['event','participant'])->latest('attended_at')->when($filters['event_id'] ?? null, fn($q, $id) => $q->where('event_id',$id))->when($filters['date'] ?? null, fn($q, $date) => $q->whereDate('attended_at',$date)); return [$query, $filters]; }
}
