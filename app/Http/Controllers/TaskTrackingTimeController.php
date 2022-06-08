<?php

namespace App\Http\Controllers;

use App\Models\TaskTrackingTime;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class TaskTrackingTimeController extends Controller
{
    public function destroy(TaskTrackingTime $trackingTime): RedirectResponse
    {
        $trackingTime->delete();

        return to_route('task.tracking', $trackingTime->task->id)->with('success', "Time tracking with time spent: {$trackingTime->spent_time} was successfully deleted");
    }

    public function toPdf(int $year, int $month)
    {
        Debugbar::disable();

        $date = Carbon::createFromDate($year, $month, 1);

        $trackingItems = TaskTrackingTime::query()
            ->with('task')
            ->whereYear('record_date', $date)
            ->whereMonth('record_date', $date)
            ->orderByRaw('record_date, task_id')
            ->get();

        return view('task-tracking-time.pdf', compact('trackingItems', 'date'));
    }
}
