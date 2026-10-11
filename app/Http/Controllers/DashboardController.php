<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Participant;
class DashboardController extends Controller
{
    public function index()
    {
        $counts = Attendance::selectRaw("status, count(*) as total")->groupBy('status')->pluck('total', 'status');
        return view('admin.dashboard', ['participantsCount' => Participant::count(), 'eventsCount' => Event::count(), 'counts' => $counts, 'latestAttendances' => Attendance::with(['event', 'participant'])->latest('attended_at')->take(8)->get()]);
    }
}
