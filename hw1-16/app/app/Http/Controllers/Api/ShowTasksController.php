<?php
namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class ShowTasksController extends Controller
{
    public function __invoke(int $taskId): JsonResponse
    {
        $task = Task::find($taskId);
        if (!$task) {
            abort(404);
        }
        return response()->json($task);
    }
}
