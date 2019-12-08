<?php

namespace App\Validators;

use App\Brackets\BracketsLevel;
use App\Brackets\BracketsLevelMap;

class Validator
{
    private $minLength = 2;
    private $bracketsLevelMap;
    private $errorOpenPosition;
    private $errorClosePosition;
    private $errorLevel;

    public function __construct(
        BracketsLevelMap $bracketsLevelMap
    )
    {
        $this->bracketsLevelMap = $bracketsLevelMap;
    }

    public function getMinLength(): int
    {
        return $this->minLength;
    }

    /**
     * @param $validatingStr
     * @return bool
     */
    public function validateLength($validatingStr)
    {
        if (strlen($validatingStr) < $this->getMinLength()) {
            return false;
        }

        return true;
    }

    /**
     * @param $validatingStr
     * @return bool
     */
    public function validateCloseBrackets(string $validatingStr)
    {
        $currentLevelIndex = 0;
        $queryLength = strlen($validatingStr);

        // в первом цикле формируем массив уровней скобок с указанием откртых и закрытых уровней
        // если встречается лишняя закрывающая скобка выбрасываем исключение
        for ($position = 0; $position < $queryLength; ++$position) {
            if ($validatingStr[$position] == '(') {
                ++$currentLevelIndex;
                $newBracketsLevel = new BracketsLevel($currentLevelIndex, $position);
                $this->bracketsLevelMap->addLevel($newBracketsLevel);
            } elseif ($validatingStr[$position] == ')') {
                if ($this->bracketsLevelMap->hasOpenLevel($currentLevelIndex)) {
                    $this->bracketsLevelMap->closeCurrentLevel($currentLevelIndex, $position);
                    --$currentLevelIndex;
                } else {
                    $errorPosition = $position + 1;
                    $this->setCloseErrorPosition($errorPosition);

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $validatingStr
     * @return bool
     */
    public function validateOpenBrackets(string $validatingStr)
    {
        // во втором цикле проверяем, что все уровни закрыты
        // если нет выбрасываем исключение с указание позиции где ожидалась закрывающая скобка
        $checkedLevels = $this->bracketsLevelMap->getLevels();
        for ($i = count($checkedLevels); $i > 0; --$i) {
            /** @var BracketsLevel $bracketsLevel */
            $bracketsLevel = $checkedLevels[$i];
            if (!$bracketsLevel->isClosedLevel()) {
                $openPosition = $bracketsLevel->getOpenPosition() + 1;
                $this->setOpenErrorPosition($openPosition);
                $errorPosition = $this->bracketsLevelMap->getErrorPosition($bracketsLevel);
                $this->setCloseErrorPosition($errorPosition);
                $this->setErrorLevel($bracketsLevel->getLevel());

                return false;
            }
        }

        return true;
    }

    private function setCloseErrorPosition(int $errorPosition)
    {
        $this->errorClosePosition = $errorPosition;
    }

    public function getCloseErrorPosition(): int
    {
        return $this->errorClosePosition;
    }

    private function setOpenErrorPosition(int $errorPosition)
    {
        $this->errorOpenPosition = $errorPosition;
    }

    public function getOpenErrorPosition(): int
    {
        return $this->errorOpenPosition;
    }

    private function setErrorLevel(int $errorLevel)
    {
        $this->errorLevel = $errorLevel;
    }

    public function getErrorLevel(): int
    {
        return $this->errorLevel;
    }
}





