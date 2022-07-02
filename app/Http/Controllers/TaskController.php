<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use App\Services\Grid\Column;
use App\Services\Grid\ColumnAction;
use App\Services\Grid\ColumnSortOrder;
use App\Services\Grid\Grid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Html\Elements\A;

class TaskController extends Controller
{
    /**
     * Tasks index
     *
     * @return View
     */
    public function index(): View
    {
        $tasks = Task::query()
            ->join('customers', 'customer_id', '=', 'customers.id')
            ->with('customer')->withSum('trackingItems', 'item_hours');

        /** @var array<int, string> $customers */
        $customers = Customer::pluck('name', 'id')->toArray();

        $grid = (new Grid())
            ->setBuilder($tasks)
            ->setConditionalRowClass(fn($data) => $data->is_active == 0 ? 'bg-red-200' : '')
            ->setColumn(
                (new Column('customer_id', 'Customer'))
                    ->setSortable(true, 'customers.name')
                    ->setFilterable(true)
                    ->setFilterOptions($customers)
                    ->setRenderWrapper(fn($data) => $data->customer->name)
            )
            ->setColumn(
                (new Column('name', 'Task name'))
                    ->setSortable(true)
                    ->setRenderWrapper(fn($data) => $data->task_url
                        ? A::create()
                            ->href($data->task_url)
                            ->target('_blank')
                            ->class('font-medium hover:underline text-blue-500')
                            ->text($data->task_name)
                            ->toHtml()
                        : $data->task_name))
            ->setColumn(
                (new Column('is_active', 'Active'))
                    ->setSortable(true)
                    ->setRenderWrapper(fn($data) => $data->is_active ? 'Yes' : 'No')
                    ->setFilterable(true)
                    ->setFilterOptions([0 => 'No', 1 => 'Yes'])
                    ->setDefaultFilterOption(1)
            )
            ->setColumn(
                (new Column('tracking_items_sum_item_hours', 'Hours'))
                    ->setSortable(true)
                    ->setRenderWrapper(fn($data) => html()->a(route('task.tracking', $data->id))->attribute('target', '_blank')->class('font-medium hover:underline text-blue-500')->text($data->tracking_items_sum_item_hours)->toHtml())
            )
            ->setColumn((new Column('task_notes', 'Task notes'))->setSortable(true))
            ->setColumn((new Column('created_at', 'Created'))->setSortable(true)->setDefaultSortOrder(ColumnSortOrder::DESC))
            ->setAction(new ColumnAction('edit', fn($data) => A::create()->href(route('task.edit', $data->id))->target('_blank')->class('font-bold text-white bg-blue-500 py-1.5 px-4 rounded')->text('Edit')));

        return view('task.index', compact('grid'));
    }

    /**
     * Task tracking time index
     *
     * @param Task $task
     * @return View
     */
    public function trackingTimeIndex(Task $task): View
    {
        $trackingItems = $task->trackingItems()->orderByRaw('item_date desc, created_at desc')->paginate(10);

        return view('task.tracking-index', compact('trackingItems', 'task'));
    }

    /**
     * Task edit view
     *
     * @param Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        return view('task.edit', compact('task'));
    }

    /**
     * Task update
     *
     * @param Task $task
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Task $task, Request $request): RedirectResponse
    {
        $task->fill($this->validateRequest($request, $task));
        $task->save();

        return to_route('task.index')->with('success', "Task `{$task->task_name}` was successfully updated");
    }

    /**
     * Task create view
     *
     * @return View
     */
    public function create(): View
    {
        $newTaskFlag = true;
        $task = new Task();

        return view('task.create', compact('newTaskFlag', 'task'));
    }

    /**
     * Task store
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $task = new Task($this->validateRequest($request, new Task()));
        $task->user_id = (int)auth()->id();
        $task->save();

        return to_route('task.index')->with('success', "Task `{$task->task_name}` was successfully created");
    }

    /**
     * Task destroy
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('task.index')->with('success', "Task `{$task->task_name}` was successfully deleted");
    }

    /**
     * Validate request
     *
     * @param Request $request
     * @param Task $task
     * @return array
     * @phpstan-return array{task_name: string, task_notes: null|string, task_url: null|string, is_active: bool}
     */
    protected function validateRequest(Request $request, Task $task): array
    {
        $taskNameRules = ['required', 'string', 'min:5', 'max:255'];

        if ($task->isDirty()) {
            $taskNameRules[] = Rule::unique('tasks', 'task_name');
        } else {
            $taskNameRules[] = Rule::unique('tasks', 'task_name')->ignore($task->id);
        }

        $rules = [
            'task_name' => $taskNameRules,
            'task_notes' => ['nullable', 'string'],
            'task_url' => ['nullable', 'url'],
        ];

        $attributes = $request->validate($rules);
        $attributes['is_active'] = $request->has('is_active');

        return $attributes;
    }
}
