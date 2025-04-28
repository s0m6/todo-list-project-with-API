<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index()
    {
        // Get the authenticated user's tasks, ordered by due_date ascending
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('due_date', 'asc')
            ->get();

        // Return the tasks to the tasks.index view
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Return the create view to show the task creation form
        return view('tasks.create');
    }

    public function store(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high'
        ]);

        // Create a new task for the authenticated user
        Task::create(array_merge($validatedData, ['user_id' => Auth::id()]));

        // Redirect back to the tasks index with a success message
        return redirect()->route('tasks.index')->with('success', 'تم إنشاء المهمه بنجاح.');
    }

    public function destroy(Task $task)
    {

        // Ensure the task belongs to the authenticated user using the Auth facade
        if ($task->user_id !== Auth::id()) {
            // Optionally, you can redirect with an error message or abort with a 403
            abort(403, 'Unauthorized action.');
        }

        // Delete the task
        $task->delete();

        // Redirect to the tasks index page with a success message
        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة بنجاح!');
    }

    public function edit(Task $task)
    {

        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Return the edit view with the task
        return view('tasks.edit', compact('task'));
    }
    public function update(Request $request, Task $task)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'تم تحديث المهمة بنجاح.');
    }



    public function toggle(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return redirect()->route('tasks.index')->with('success', 'تم  تحديث حاله  المهمة بنجاح.');
    }
}
