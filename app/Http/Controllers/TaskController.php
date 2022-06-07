<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskTrackingTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->where('is_active', true)
            ->withSum('trackingTimes', 'spent_time')
            ->paginate(10);

        return view('task.index', compact('tasks'));
    }

    public function edit(Task $task): View
    {
        $sum = TaskTrackingTime::where('task_id', $task->id)->sum('spent_time');
        $trackingTimes = $task->trackingTimes()->orderByRaw('record_date desc, created_at desc')->get();

        return view('task.edit', compact('task', 'sum', 'trackingTimes'));
    }

    public function update(Task $task): RedirectResponse
    {
        $request = request();
        $attributes = $request->validate([
            'task_name' => ['required', 'string', Rule::unique('tasks', 'task_name')->ignore($task->id)],
            'task_notes' => ['nullable', 'string'],
            'task_url' => ['nullable', 'string'],
        ]);
        $attributes['is_active'] = $request->has('is_active');

        dd($attributes);

        return to_route('task.index');
    }
}
