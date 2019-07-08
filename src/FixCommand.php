<?php

namespace lexerom;

use lexerom\Commands\AbstractCommand;
use lexerom\Commands\GroupInterface;
use lexerom\Commands\MatchInterface;
use lexerom\Commands\NotFound;
use lexerom\Exceptions\InvalidCommandGroup;

class FixCommand
{
    private $commandGroups = [
        'git' => 'lexerom\Commands\Git\Git'
    ];

    private $input;

    /**
     * @var AbstractCommand
     */
    private $command;

    public function __construct(string $input)
    {
        $this->input = $input;

        $this->command = $this->parse();

        if (!$this->command) {
            $this->command = new NotFound('not found');
        }
    }

    private function parse(): ?AbstractCommand
    {
        $groupFound = false;
        foreach ($this->commandGroups as $groupName) {
            $group = new $groupName($this->input);

            if (!($group instanceof MatchInterface && $group instanceof GroupInterface)) {
                throw new InvalidCommandGroup(sprint('Invalid group provided: %s', $groupName));
            }
            /**
             * @var GroupInterface|MatchInterface $group
             */
            if ($group->match()) {
                $groupFound = true;
                break;
            }
        }

        if (!$groupFound) {
            return null;
        }

        foreach($group->getCommands() as $commandName) {
            /**
             * @var AbstractCommand $command
             */

            $command = new $commandName($this->input);

            if ($command->match()) {
                return $command;
                break;
            }
        }

        return null;
    }

    public function execute(): void
    {
        if ($this->command->execute()) {
            exec($this->command->getValidCommandWithArgs(), $output, $return);
            fputs(STDOUT, join(PHP_EOL, $output) . PHP_EOL);
        }
    }
}