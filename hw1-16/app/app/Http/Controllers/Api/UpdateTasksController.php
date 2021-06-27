<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class UpdateTasksController extends Controller
{
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        $task = Task::find($taskId);
        if (!$task) {
            abort(404);
        }
        $task->update($request->all());
        return response()->json($task);
    }
}
