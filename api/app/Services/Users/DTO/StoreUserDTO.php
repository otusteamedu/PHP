<?php

namespace App\Services\Users\DTO;

use Illuminate\Contracts\Support\Arrayable;

class StoreUserDTO implements Arrayable
{
    private string $name;
    private string $email;
    private string $password;
    private string $request_id;

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $request_id
     */
    public function __construct(string $name, string $email, string $password, string $request_id)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->request_id = $request_id;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['request_id'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'request_id' => $this->getRequestId(),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->request_id;
    }

    /**
     * @return array
     */
    public function toReturn(): array
    {
        return array_diff_key($this->toArray(), array_flip($this->hidden));
    }

}
