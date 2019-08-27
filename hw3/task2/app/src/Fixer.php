<?php
/**
* Class for command line typos fixing
*
* @author Evgeny Prokhorov <contact@jekys.ru>
* @package php-fuck
*/
namespace Jekys;

use Jekys\Text as Txt;

class Fixer
{
    /**
    * @var string $brokenCmd - broken command needs to be fixed
    */
    private $brokenCmd;

    /**
    * @var array $possibleFix - structure to store the typo and possible fixing options
    */
    private $possibleFix;

    /**
    * @var string $app - what app has been called with typo
    */
    private $app = null;

    /**
    * @var array $knownApps - describes how to find typo in command and where to find possible options to fix it.
    */
    private $knownApps = [
        'git' => [
            'typo' => [
                'line' => 0,
                'pattern' => "/git: '(.*)' is not a git command. See 'git --help'./"
            ],
            'options' => 3
        ],
    ];

    /**
    * Class entity constructor
    *
    * @param string $brokenCmd - command to fix
    *
    * @return Fixer
    */
    public function __construct(String $brokenCmd)
    {
        $this->brokenCmd = $brokenCmd;
    }

    /**
    * Starts typo fixing
    *
    * @return boolean
    */
    public function run()
    {
        if (!$this->defineApp()) {
            echo Txt::red("Sorry, I can't help with this command".PHP_EOL);

            return false;
        }

        if (!$this->findPossibleFixes()) {
            echo Txt::red('I have no idea how to fix it'.PHP_EOL);

            return false;
        }

        $correction = $this->getCorrection();

        print $correction['output'];
        $userChoice = readline();

        $applyCmd = $correction['command'];
        if (!empty($userChoice)) {
            $applyCmd = trim($userChoice);
        }
        echo shell_exec($applyCmd);

        return true;
    }

    /**
    * Returns correction for user interface
    *
    * @return array
    */
    private function getCorrection()
    {
        $correctCmd = $this->getCorrectCmd(
            $this->possibleFix['typo'],
            current($this->possibleFix['options'])
        );

        $correction = [
            'command' => $correctCmd,
            'output' => $correctCmd.' ['.Txt::green('enter').'/'.Txt::red('ctrl+c').'] '
        ];

        if (count($this->possibleFix['options']) > 1) {
            foreach ($this->possibleFix['options'] as $option) {
                readline_add_history(
                    $this->getCorrectCmd(
                        $this->possibleFix['typo'],
                        $option
                    )
                );

                $correction['output'] = $correctCmd.' ['.Txt::green('enter').'/↑/↓/'.Txt::red('ctrl+c').'] ';
            }
        }

        return $correction;
    }

    /**
    * Returns correct command
    *
    * @param string typo - typo from command
    * @param string correct - how to replace the typo
    *
    * @return string
    */
    private function getCorrectCmd(String $typo, String $correct)
    {
        return str_replace($typo, $correct, $this->brokenCmd);
    }

    /**
    * Runs broken command and parse error output
    *
    * @return boolean
    */
    private function findPossibleFixes()
    {
        exec($this->brokenCmd.' 2>&1 ', $error);

        $possibleFix = [
            'typo' => '',
            'options' => []
        ];

        $rules = $this->knownApps[$this->app];

        $possibleFix['typo'] = trim(preg_replace(
            $rules['typo']['pattern'],
            '$1',
            $error[$rules['typo']['line']]
        ));

        for ($i = $rules['options']; $i < count($error); $i++) {
            if (!empty($error[$i])) {
                $possibleFix['options'][] = trim($error[$i]);
            }
        }

        if (empty($possibleFix['typo']) || empty($possibleFix['options'])) {
            return false;
        } else {
            $this->possibleFix = $possibleFix;

            return true;
        }
    }

    /**
    * Defines what app has been called with typo
    *
    * @return boolean
    */
    private function defineApp()
    {
        $splited = explode(' ', $this->brokenCmd);

        if (array_key_exists($splited[0], $this->knownApps)) {
            $this->app = $splited[0];

            return true;
        } else {
            return false;
        }
    }

    /**
    * Puts "fuck" alias to the users .bashrc
    *
    * @return void
    */
    public static function addAlias()
    {
        $alias = "alias fuck='php-fuck --fix=\"$(fc -ln -2 | head -n 1)\"'";
        file_put_contents($_SERVER['HOME'].'/.bashrc', $alias.PHP_EOL, FILE_APPEND);
    }
}
