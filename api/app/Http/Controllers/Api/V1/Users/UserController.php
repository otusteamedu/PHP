<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\V1\Users\Request\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends BaseUserController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function list(Request $request): JsonResponse
    {
        $limit = $request->get('limit', self::USERS_PER_PAGE);
        $offset = $request->get('offset', 0);
        $this->validate($request, [
            'limit' => 'max:' . self::MAX_USERS_PER_PAGE,
        ]);
        $qb = User::query();
        $qb->take($limit);
        $qb->skip($offset);
        return response()->json($qb->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $dto = $request->getDTO();
        $this->getUserService()->storeUser($dto);
        return response()->json($dto->toReturn());

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $qb = User::where('id', $id);
        return response()->json($qb->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $userData = $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $userData['password'] = Hash::make($userData['password']);
        $result = $user->update($userData);
        return response()->json(['result' => $result, 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $qb = User::find($id);
        $result = $qb ? $qb->delete() : "User with id=$id not found";
        return response()->json($result);
    }

    /**
     * Поиск имущества для пользователя
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getEstate(User $user): JsonResponse
    {
        $this->getEstateService()->findAll($user);
        return response()->json(['user' => $user->name, 'server answer' => 'The estate search request has been accepted. Expect an answer']);
    }
}
