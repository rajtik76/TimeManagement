<?php

namespace App\Http\Controllers;

use App\Models\TaskTrackingTime;
use Illuminate\Http\RedirectResponse;

class TaskTrackingTimeController extends Controller
{
    public function destroy(TaskTrackingTime $trackingTime): RedirectResponse
    {
        $trackingTime->delete();

        return to_route('task.tracking', $trackingTime->task->id)->with('success', "Time tracking with time spent: {$trackingTime->spent_time} was successfully deleted");
    }
}
