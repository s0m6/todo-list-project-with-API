<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    //Display a listing of the authenticated user's tasks.
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks),
        ]);
    }


     //Store a newly created task for the authenticated user.
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after_or_equal:today',
            'priority'    => 'required|in:low,medium,high'
        ], [
            'title.required'        => 'حقل العنوان مطلوب.',
            'title.max'             => 'يجب ألا يتجاوز العنوان 255 حرفًا.',
            'description.string'    => 'يجب أن يكون الوصف نصًا.',
            'due_date.required'     => 'حقل تاريخ الاستحقاق مطلوب.',
            'due_date.date'         => 'يجب أن يكون تاريخ الاستحقاق تاريخًا صالحًا.',
            'due_date.after_or_equal' => 'يجب أن يكون تاريخ الاستحقاق اليوم أو تاريخًا مستقبليًا.',
            'priority.required'     => 'حقل الأولوية مطلوب.',
            'priority.in'           => 'قيمة الأولوية غير صالحة. اختر من بين: منخفض، متوسط، عالي.'
        ]);

        $task = Task::create(array_merge($validated, ['user_id' => Auth::id()]));

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully.',
            'data' => $task
        ], 201);
    }


     //Update the specified task if it belongs to the authenticated user.
    public function update(Request $request, Task $task): JsonResponse
    {

        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after_or_equal:today',
            'priority'    => 'required|in:low,medium,high'
        ], [
            'title.required'        => 'حقل العنوان مطلوب.',
            'title.max'             => 'يجب ألا يتجاوز العنوان 255 حرفًا.',
            'description.string'    => 'يجب أن يكون الوصف نصًا.',
            'due_date.required'     => 'حقل تاريخ الاستحقاق مطلوب.',
            'due_date.date'         => 'يجب أن يكون تاريخ الاستحقاق تاريخًا صالحًا.',
            'due_date.after_or_equal' => 'يجب أن يكون تاريخ الاستحقاق اليوم أو تاريخًا مستقبليًا.',
            'priority.required'     => 'حقل الأولوية مطلوب.',
            'priority.in'           => 'قيمة الأولوية غير صالحة. اختر من بين: منخفض، متوسط، عالي.'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'data' => $task
        ]);
    }


     //Remove the specified task from storage.
    public function destroy($taskId): JsonResponse
    {
        // Try to find the task by ID
        $task = Task::find($taskId);

        // If the task doesn't exist, return a custom error message
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.'
            ], 404);
        }

        // Check if the authenticated user is the owner of the task
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Proceed with deleting the task
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.'
        ]);
    }


     //Toggle the completion status of the task.
    public function toggle(Task $task): JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
            ], 403);
        }

        // Toggle the 'is_completed' status
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        // Return the updated task in the response
        return response()->json([
            'success' => true,
            'message' => 'Task status updated.',
            'data' => $task
        ]);
    }
}
