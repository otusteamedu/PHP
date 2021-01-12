<?php


namespace Otushw;

use Exception;

class Params
{
    const GRABBER = 'grabber';
    const STATS = 'stats';
    const ALLOWED_TYPE = [self::GRABBER, self::STATS];

    private string $param;

    public function __construct()
    {
        $this->validateParam();
        $this->setParam($_SERVER['argv'][1]);
    }

    private function validateParam()
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new UserException('To run the script, need the parameter.');
        }
        if (empty($_SERVER['argv'][1])) {
            throw new UserException('Parameter is empty.');
        }
        if (!in_array($_SERVER['argv'][1], self::ALLOWED_TYPE)) {
            throw new UserException('Invalid parameter value. Allowed "'
                . self::GRABBER . '" or "' . self::STATS . '"');
        }
    }

    /**
     * @param string $param
     */
    public function setParam(string $param)
    {
        $this->param = $param;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getParam(): string
    {
        if (empty($this->param)) {
            throw new AppException('Parameter was not set.');
        }
        return $this->param;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isGrabber(): bool
    {
        return $this->checkParam(self::GRABBER);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isStats(): bool
    {
        return $this->checkParam(self::STATS);
    }

    /**
     * @param string $param
     *
     * @return bool
     * @throws Exception
     */
    private function checkParam(string $param): bool
    {
        if ($this->getParam() == $param) {
            return true;
        }
        return false;
    }

}