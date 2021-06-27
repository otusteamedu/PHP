<?php
namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class GetTasksController extends Controller
{
    const MODELS_PER_PAGE = 10;
    const MAX = 30;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $limit = $request->get('limit', self::MODELS_PER_PAGE);
        $offset = $request->get('offset', 0);

        $tasks = Task::query()
            ->take($limit)
            ->skip($offset)
            ->orderBy('id', 'DESC')->get();

        return response()->json($tasks);
    }
}
