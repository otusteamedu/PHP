<?php


namespace HW7_1;

use InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheValidationWrapper
 * @package HW7_1
 */
class CacheValidationWrapper extends AbstractBaseValidation
{
    /**
     * @var Validation
     */
    private $validation;
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * CacheablesValidationWrapper constructor.
     * @param Validation $validation
     * @param CacheInterface $cache
     */
    public function __construct(Validation $validation, CacheInterface $cache)
    {
        $this->validation = $validation;
        $this->cache = $cache;
    }

    /**
     * @param string $email
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function validate(string $email): bool
    {
        if (empty($this->cache)) {
            $this->error(sprintf('Check email in cache %s', $email));
            throw new InvalidArgumentException('Need for set cache!');
        }
        $this->debug(sprintf('Check email in cache %s', $email));
        $result = $this->cache->get($email);
        if (isset($result)) {
            $this->debug(sprintf('Found email in cache %s : %b', $email, $result));
            return $result;
        }
        $result = $this->validation->validate($email);
        $this->debug(sprintf('Place email check result in cache %s : %b', $email, $result));
        $this->cache->set($email, $result);
        return $result;
    }
}
