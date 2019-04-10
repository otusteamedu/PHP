<?php

namespace nvggit;

class Check
{
    public function getVocabulary(): array
    {
        return [
            "git commit"
        ];
    }

    public function exec($input)
    {
        $checks = array();

        foreach ($this->getVocabulary() as $command) {
            $checks[$command] = similar_text($command, $input);
        }

        $matchCommand = array_keys($checks, max($checks))[0];

        if (max($checks) === 10) {
             shell_exec($matchCommand);
             return null;
        }

        return $this->getSuggestionText($matchCommand);
    }

    public function getSuggestionText($command)
    {
        return "Did you mean $command?\n\r";
    }
}