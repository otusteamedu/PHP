<?php

namespace App\Http\Controllers;

use App\Jobs\MessageJob;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QueueController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $message = new Message();
        $message->uuid = $this->dispatch(new MessageJob());
        $message->data = $request->all();
        $message->save();

        return response()
            ->json(['uuid' => $message->uuid])
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function show(string $uuid): Response
    {
        $message = Message::findOrFail($uuid);

        return response()->json([
            'uuid' => $message->uuid,
            'created_at' => $message->created_at,
            'status' => __('status.' . $message->status),
            'data' => $message->data,
        ], Response::HTTP_OK);
    }
}
