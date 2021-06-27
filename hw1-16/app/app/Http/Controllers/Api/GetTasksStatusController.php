<?php
namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class GetTasksStatusController extends Controller
{

    public function __invoke(Request $request): JsonResponse
    {
        $taskId = $request->get('id');
        $status = '';
        if ($taskId) {
            $task = $this->getTasksRequest((int)($taskId));
            if (!empty($task)) {
                $status = $task['status'];
            }
        }

        return response()->json($status);
    }

    private function getTasksRequest($tasksId)
    {
        return Task::find($tasksId);
    }
}
