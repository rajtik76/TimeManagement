<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use App\Models\TaskTrackingItem;
use App\Services\GridInstancesForControllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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

        return view('task.index', ['grid' => GridInstancesForControllers::taskControllerIndex($tasks)]);
    }

    /**
     * Task tracking time index
     *
     * @param Task $task
     * @return View
     */
    public function trackingTimeIndex(Task $task): View
    {
        return view('task.tracking-index', ['grid' => GridInstancesForControllers::taskControllerTrackingTimeIndex(TaskTrackingItem::query()->where('task_id', $task->id)), 'task' => $task]);
    }

    /**
     * Task edit view
     *
     * @param Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        return view('task.edit', ['task' => $task, 'customers' => Customer::pluck('name', 'id')->toArray()]);
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
        return view('task.create', ['newTaskFlag' => true, 'task' => new Task(), 'customers' => Customer::pluck('name', 'id')->toArray()]);
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
            'customer_id' => 'required|exists:customers,id',
            'task_name' => $taskNameRules,
            'task_notes' => ['nullable', 'string'],
            'task_url' => ['nullable', 'url'],
        ];

        $attributes = $request->validate($rules);
        $attributes['is_active'] = $request->has('is_active');

        return $attributes;
    }
}
