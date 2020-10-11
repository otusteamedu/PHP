<?php

namespace Otus;

use Otus\Entities\Mail;
use Otus\Entities\MailCollection;
use Otus\Entities\MailMapper;

class ORM
{
    private IdentityMap $map;

    private MailMapper $mapper;

    public function __construct(MailMapper $mapper, IdentityMap $map)
    {
        $this->mapper = $mapper;
        $this->map    = $map;
    }

    public function find(int $id): ?Mail
    {
        $key = IdentityKey::make(Mail::class, $id)->get();

        if ($this->map->has($key)) {
            return $this->map->get($key);
        }

        $mail = $this->mapper->find($id);
        $this->map->set($key, $mail);

        return $mail;
    }

    public function all(): MailCollection
    {
        return $this->mapper->all();
    }

    public function insert(array $data): Mail
    {
        $mail = $this->mapper->insert($data);
        $key  = (new IdentityKey(Mail::class, $mail->getId()))->get();
        $this->map->set($key, $mail);

        return $mail;
    }

    public function update(Mail $mail): bool
    {
        return $this->mapper->update($mail);
    }

    public function delete(Mail $mail): bool
    {
        if ($this->mapper->delete($mail) === false) {
            return false;
        }

        $key  = IdentityKey::make(Mail::class, $mail->getId())->get();
        $this->map->delete($key);

        return true;
    }
}
