<?php
namespace App\Http\Controllers\Api;

use App\Jobs\ProccesedTaskJob;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class StoreTasksController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        $task = Task::create($request->all());
        $this->dispatch(new ProccesedTaskJob($task));
        return response()->json($task);
    }
}
