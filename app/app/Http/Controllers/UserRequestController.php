<?php

namespace App\Http\Controllers;

use App\Jobs\FilmReportSend;
use App\Models\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Class UserRequestController
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="User Request Api",
 *         @OA\License(name="MIT")
 *     ),
 * )
 */
class UserRequestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user-requests/show",
     *     summary="Get user request",
     *     operationId="show",
     *     tags={"UserRequest"},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="int",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             description="Allowed: film_report",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User request data",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(
     *                  @OA\Property(property="data", type="array",
     *                       @OA\Items(
     *                          @OA\Property(property="request_id", type="int"),
     *                          @OA\Property(property="request_type", type="string"),
     *                          @OA\Property(property="request_status", type="string")
     *                      )
     *                  ),
     *
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'exists:user_requests,id'],
            'type' => ['required', 'in:' . implode(',', UserRequest::TYPES_ALLOWED)],
            'email' => ['required', 'email',
                Rule::exists('user_requests', 'email')->where('id', $request->get('id'))
            ],
        ]);

        $userRequest = UserRequest::find($request->get('id'));

        return response()->json([
            'data' => [
                'request_id' => $userRequest->id,
                'request_type' => $userRequest->type,
                'request_status' => $userRequest->status,
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/user-requests",
     *     summary="Create user request",
     *     operationId="store",
     *     tags={"UserRequest"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             description="Allowed: film_report",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User request data",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(
     *                  @OA\Property(property="data", type="array",
     *                       @OA\Items(
     *                          @OA\Property(property="request_id", type="int"),
     *                          @OA\Property(property="request_type", type="string")
     *                      )
     *                  ),
     *
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', 'in:' . implode(',', UserRequest::TYPES_ALLOWED)],
            'email' => ['required', 'email'],
        ]);

        $userRequest = UserRequest::create([
            'type' => $request->get('type'),
            'email' => $request->get('email'),
        ]);

        dispatch(new FilmReportSend($userRequest->id));

        return response()->json([
            'data' => [
                'request_id' => $userRequest->id,
                'request_type' => $userRequest->type,
            ]
        ]);
    }
}
