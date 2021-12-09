<?php

namespace App\Http\Controllers\Api\V1\Users\Request;

use App\Services\Users\DTO\StoreUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => [
                'min:6',
                'max:255',
            ],
        ];
    }

    /**
     * @return StoreUserDTO
     */
    public function getDTO(): StoreUserDTO
    {
        $userData = $this->validated();
        $userData['password'] = Hash::make($userData['password']);
        return StoreUserDTO::fromArray(array_merge($userData, [
            'request_id' => $this->generateRequestId(),
        ]));
    }

    /**
     * @return string
     */
    private function generateRequestId(): string
    {
        return Str::uuid()->toString();
    }

}
