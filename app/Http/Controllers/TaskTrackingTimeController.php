<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskTrackingItem;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskTrackingTimeController extends Controller
{
    public function destroy(TaskTrackingItem $item): RedirectResponse
    {
        $item->delete();

        return to_route('task.tracking', $item->task->id)->with('success', "Time tracking with time spent: {$item->item_hours} was successfully deleted");
    }

    public function toPdf(int $year, int $month)
    {
        Debugbar::disable();

        $date = Carbon::createFromDate($year, $month, 1);

        $items = TaskTrackingItem::query()
            ->with('task')
            ->whereYear('item_date', $date)
            ->whereMonth('item_date', $date)
            ->orderByRaw('item_date, task_id')
            ->get();

        return view('tracking-item.pdf', compact('items', 'date'));
    }

    /**
     * Create tracking item
     */
    public function create(Task $task): View
    {
        $flagNewItem = true;
        $item = new TaskTrackingItem();

        return view('tracking-item.create', compact('flagNewItem', 'item', 'task'));
    }

    /**
     * Edit tracking item
     */
    public function edit(TaskTrackingItem $item): View
    {
        return view('tracking-item.edit', compact('item'));
    }

    /**
     * Tracking item update
     */
    public function update(TaskTrackingItem $item, Request $request): RedirectResponse
    {
        $item->fill($this->validateRequest($request, false));
        $item->save();

        return to_route('task.tracking', $item->task->id)->with('success', "Your tracked item id:{$item->id} was successfully edited");
    }

    /**
     * Store tracking item
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->validateRequest($request, true);

        $item = new TaskTrackingItem($attributes);
        $item->task_id = $attributes['task_id'];
        $item->save();

        return to_route('task.tracking', $item->task->id)->with('success', "Your tracked item id:{$item->id} was successfully edited");
    }

    /**
     * Validate request
     */
    protected function validateRequest(Request $request, bool $newItem): array
    {
        $rules = [
            'item_date' => 'required|date_format:Y-m-d',
            'item_hours' => 'required|numeric',
            'item_note' => 'nullable|string',
        ];

        if ($newItem) {
            $rules['task_id'] = 'required|numeric';
        }

        return $request->validate($rules);
    }
}
