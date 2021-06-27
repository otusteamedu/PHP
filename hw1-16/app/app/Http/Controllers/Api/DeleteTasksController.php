<?php
namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class DeleteTasksController extends Controller
{
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $task = Task::find($taskId);
        if (!$task) {
            abort(404);
        }
        return response()->json($task->delete());
    }
}
