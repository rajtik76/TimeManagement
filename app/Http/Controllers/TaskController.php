<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()->where('is_active', true)->paginate();

        return view('task.index', compact('tasks'));
    }
}
