<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace AsFuck;

class Analyser
{
    public const DISTANCE_THRESHOLD = 2;
    private $commandToFix;

    public function __construct(string $commandToFix)
    {
        $this->commandToFix = $commandToFix;
    }


    public function getProperComamnd(): ?string
    {
        if ($this->isKnownCommand($this->getCommandsAsArray(), Dictionary::getDictionary())) {
            return null;
        }

        $stats = $this->getAnalysis($this->getCommandsAsArray(), Dictionary::getDictionary());

        if ($this->canBeFixed($stats)) {
            return $this->getFixedCommand($stats);
        } else {
            return null;
        }
    }

    private function getCommandsAsArray(): array
    {
        $commands = explode(' ', $this->commandToFix);
        array_shift($commands);
        return $commands;
    }

    private function isKnownCommand(?array $commandKeyWords, ?array $dictionary): bool
    {
        if (empty($commandKeyWords)) {
            return true;
        }
        $currentCommandKeyWord = $commandKeyWords[0];

        if ($this->isInDictionary($currentCommandKeyWord, $dictionary)) {
            array_shift($commandKeyWords);
            return $this->isKnownCommand($commandKeyWords, $dictionary[$currentCommandKeyWord]);
        }

        if (empty($dictionary)) {
            return true;
        }

        return false;
    }

    private function getAnalysis(?array $commandKeyWords, ?array $dictionary): ?array
    {
        if (empty($commandKeyWords)) {
            return [];
        }
        $currentCommandKeyWord = $commandKeyWords[0];

        if ($this->isInDictionary($currentCommandKeyWord, $dictionary)) {
            array_shift($commandKeyWords);
            $nextRoundResult = $this->getAnalysis($commandKeyWords, $dictionary[$currentCommandKeyWord]);

            if ($nextRoundResult === null) {
                return [];
            } else {
                return array_merge([$currentCommandKeyWord => 0], $nextRoundResult);
            }
        } else {
            $mostSimilarWord = $this->getMostSimilarWord($currentCommandKeyWord, array_keys($dictionary));

            if (empty($mostSimilarWord)) {
                return [];
            }

            array_shift($commandKeyWords);
            $nextRoundResult = $this->getAnalysis($commandKeyWords, $dictionary[array_keys($mostSimilarWord)[0]]);

            if ($nextRoundResult === null) {
                return [];
            } else {
                return array_merge($mostSimilarWord, $nextRoundResult);
            }
        }
    }

    private function getMostSimilarWord(string $word, array $dictionary): array
    {
        $result = [];

        foreach ($dictionary as $dictionaryWord) {
            $result[$dictionaryWord] = $this->getDistance($word, $dictionaryWord);
        }

        $mostSimilarWord = $this->getWordWithMinimalValue($result);

        if (array_values($mostSimilarWord)[0] > self::DISTANCE_THRESHOLD) {
            return [];
        }

        return $mostSimilarWord;
    }

    private function getDistance(string $srt1, string $srt2): int
    {
        return levenshtein($srt1, $srt2);
    }

    private function getWordWithMinimalValue(array $stats): array
    {
        $minValue = min($stats);
        return [array_search(min($stats), $stats) => $minValue];
    }

    private function canBeFixed(array $stats): bool
    {
        if (array_sum($stats) < self::DISTANCE_THRESHOLD * count($stats)) {
            return true;
        }
        return false;
    }

    private function getFixedCommand(array $stats): string
    {
        return implode(' ', array_keys($stats));
    }

    private function isInDictionary(string $word, array $dictionary): bool
    {
        return in_array($word, array_keys($dictionary));
    }

}