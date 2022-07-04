<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use App\Models\TaskTrackingItem;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class TaskTrackingTimeController extends Controller
{
    /**
     * Destroy
     *
     * @param TaskTrackingItem $item
     * @return RedirectResponse
     */
    public function destroy(TaskTrackingItem $item): RedirectResponse
    {
        if ($item->task) {

            $item->delete();
        } else {

            throw new InvalidArgumentException("Task ID not found");
        }

        return to_route('task.tracking', $item->task->id)->with('success', "Time tracking with time spent: {$item->item_hours} was successfully deleted");
    }

    /**
     * Items overview
     *
     * @return View
     */
    public function overview(): View
    {
        return view('tracking-item.overview', ['customers' => Customer::pluck('name', 'id')->toArray()]);
    }

    /**
     * Printable items overview
     *
     * @param Request $request
     * @return View
     */
    public function printableOverview(Request $request): View
    {
        $attributes = $request->validate([
            'overview_date' => 'required|date_format:m/Y',
            'customer' => 'required|int|exists:customers,id',
        ]);

        $date = Carbon::createFromFormat('d/m/Y', '1/' . $attributes['overview_date']);

        if (!$date) {
            throw new InvalidArgumentException("Date can't be created");
        }

        $items = TaskTrackingItem::query()
            ->whereHas('task', fn (Builder $builder) => $builder->where('customer_id', $attributes['customer']))
            ->with(['task', 'task.customer'])
            ->whereYear('item_date', strval($date->year))
            ->whereMonth('item_date', strval($date->month))
            ->orderByRaw('item_date, task_id')
            ->get();

        return view('tracking-item.overview-pdf', ['items' => $items, 'date' => $date, 'customer' => Customer::find($attributes['customer'])]);
    }

    /**
     * Create tracking item
     *
     * @param Task $task
     * @return View
     */
    public function create(Task $task): View
    {
        $flagNewItem = true;
        $item = new TaskTrackingItem();

        return view('tracking-item.create', compact('flagNewItem', 'item', 'task'));
    }

    /**
     * Edit tracking item
     *
     * @param TaskTrackingItem $item
     * @return View
     */
    public function edit(TaskTrackingItem $item): View
    {
        return view('tracking-item.edit', compact('item'));
    }

    /**
     * Tracking item update
     *
     * @param TaskTrackingItem $item
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(TaskTrackingItem $item, Request $request): RedirectResponse
    {
        if ($item->task) {

            $item->fill($this->validateRequest($request, false));
            $item->save();
        } else {

            throw new InvalidArgumentException("Task ID not found");
        }

        return to_route('task.tracking', $item->task->id)->with('success', "Your tracked item id:{$item->id} was successfully edited");
    }

    /**
     * Store tracking item
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->validateRequest($request, true);

        $item = new TaskTrackingItem($attributes);
        $item->task_id = $attributes['task_id'];
        $item->save();

        return to_route('task.tracking', $item->task_id)->with('success', "Your tracked item id:{$item->id} was successfully edited");
    }

    /**
     * Validate request
     *
     * @param Request $request
     * @param bool $newItem
     * @return array
     * @phpstan-return array{item_date: string, item_hours: int, item_note: null|string, task_id: int, item_date: Carbon}
     */
    protected function validateRequest(Request $request, bool $newItem): array
    {
        $rules = [
            'item_date' => 'required|date_format:d/m/Y',
            'item_hours' => 'required|numeric',
            'item_note' => 'nullable|string',
        ];

        if ($newItem) {

            $rules['task_id'] = 'required|numeric';
        }

        $attributes = $request->validate($rules);

        if ($date = Carbon::createFromFormat('d/m/Y', $attributes['item_date'])) {

            $attributes['item_date'] = $date;
        } else {

            throw new InvalidArgumentException("Can't parse date `{$attributes['item_date']}` to Carbon");
        }


        return $attributes;
    }
}
