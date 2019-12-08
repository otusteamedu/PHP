<?php

namespace App\Validators;

use App\Brackets\BracketsLevel;
use App\Brackets\BracketsLevelMap;
use App\Exceptions\ValidatorException;

class Validator
{
    private $minLength = 2;

    public function getMinLength(): int
    {
        return $this->minLength;
    }

    /**
     * @param $validatingStr
     * @throws ValidatorException
     */
    public function validateLength($validatingStr)
    {
        if (strlen($validatingStr) < $this->getMinLength()) {
            throw new ValidatorException("Количество переданных скобок должно быть больше {$this->getMinLength()}", 400);
        }
    }

    /**
     * @param $validatingStr
     * @throws ValidatorException
     */
    public function validateBrackets(string $validatingStr)
    {
        $bracketsLevelMap = new BracketsLevelMap();
        $currentLevelIndex = 0;
        $queryLength = strlen($validatingStr);

        // в первом цикле формируем массив уровней скобок с указанием откртых и закрытых уровней
        // если встречается лишняя закрывающая скобка выбрасываем исключение
        for ($position = 0; $position < $queryLength; ++$position) {
            if ($validatingStr[$position] == '(') {
                ++$currentLevelIndex;
                $newBracketsLevel = new BracketsLevel($currentLevelIndex, $position);
                $bracketsLevelMap->addLevel($newBracketsLevel);
            } elseif ($validatingStr[$position] == ')') {
                if ($bracketsLevelMap->hasOpenLevel($currentLevelIndex)) {
                    $bracketsLevelMap->closeCurrentLevel($currentLevelIndex, $position);
                    --$currentLevelIndex;
                } else {
                    $errorPosition = $position + 1;
                    throw new ValidatorException("Нет открывающей скобки для закрывающей скобки расположенной на позиции {$errorPosition}", 400);
                }
            }
        }

        // во втором цикле проверяем, что все уровни закрыты
        // если нет выбрасываем исключение с указание позиции где ожидалась закрывающая скобка
        $checkedLevels = $bracketsLevelMap->getLevels();
        for ($i = count($checkedLevels); $i > 0; --$i) {
            /** @var BracketsLevel $bracketsLevel */
            $bracketsLevel = $checkedLevels[$i];
            if (!$bracketsLevel->isClosedLevel()) {
                $openPosition = $bracketsLevel->getOpenPosition() + 1;
                $errorPosition = $bracketsLevelMap->getErrorPosition($bracketsLevel);
                throw new ValidatorException("Открывающая скобка уровня {$bracketsLevel->getLevel()}, открытая на позиции {$openPosition} не имеет закрывающей скобки на позиции {$errorPosition}", 400);
            }
        }
    }
}





