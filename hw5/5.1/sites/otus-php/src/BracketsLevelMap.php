<?php

namespace App\Brackets;

class BracketsLevelMap
{
    // массив уровней для цикла первой проверки,
    // проверяется на лишние закрывающие скобки
    private $validatingBracketsLevels = [];
    // массив содержащие корректные закрытые уровни и не закрытые
    // не закртые уровни проверяются в цикле начиная с самого нижнего
    private $checkedBracketsLevels = [];

    public function getLevels(): array
    {
        return $this->checkedBracketsLevels;
    }

    /**
     * @param BracketsLevel $bracketsLevel
     */
    public function addLevel(BracketsLevel $bracketsLevel)
    {
        $level = $bracketsLevel->getLevel();
        $this->validatingBracketsLevels[$level] = $bracketsLevel;
        $this->checkedBracketsLevels[$level] = $bracketsLevel;
    }

    /**
     * @param int $level
     * @return bool
     */
    public function hasOpenLevel(int $level): bool
    {
        if (!isset($this->validatingBracketsLevels[$level])) {
            return false;
        }

        return true;
    }

    /**
     * @param int $level
     * @param int $position
     */
    public function closeCurrentLevel(int $level, int $position): void
    {
        unset($this->validatingBracketsLevels[$level]);
        $bracketsLevel = $this->getCheckedBracketsLevel($level);
        $bracketsLevel->closeLevel($position);
    }

    /**
     * @param int $level
     * @return BracketsLevel|null
     */
    public function getCheckedBracketsLevel(int $level): ?BracketsLevel
    {
        if (empty($this->checkedBracketsLevels[$level])) {

            return null;
        }

        return $this->checkedBracketsLevels[$level];
    }

    /**
     * @param BracketsLevel $bracketsLevel
     * @return int
     */
    public function getErrorPosition(BracketsLevel $bracketsLevel): int
    {
        $deeperLevel = $bracketsLevel->getLevel() + 1;
        if ($deeperBracketsLevel = $this->getCheckedBracketsLevel($deeperLevel)) {
            $prevClosePosition = $deeperBracketsLevel->getClosePosition();
            if ($prevClosePosition > $bracketsLevel->getOpenPosition()) {
                // +1 - следующая позиция, +1 - для вывода, т.к. строки начинаются с 0 индекса
                $errorPosition = $prevClosePosition + 2;

                return $errorPosition;
            }
        }

        return $bracketsLevel->getOpenPosition() + 2;
    }
}





