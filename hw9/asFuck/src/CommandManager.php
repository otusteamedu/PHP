<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace AsFuck;

class CommandManager
{
    public const COMMAND_FILE = __DIR__ . '/../commandToRun';

    public static function saveCommandToRun(string $command): void
    {
        self::deleteSavedCommand();
        file_put_contents(self::COMMAND_FILE, $command);
    }

    public static function deleteSavedCommand(): void
    {
        if (file_exists(self::COMMAND_FILE)) {
            unlink(self::COMMAND_FILE);
        }
    }

    public static function executeCommand(): void
    {
        if (file_exists(self::COMMAND_FILE)) {
            $command = file_get_contents(self::COMMAND_FILE);
            exec($command);
            self::deleteSavedCommand();
        } else {
            echo "Nothing to fuck";
        }
    }
}