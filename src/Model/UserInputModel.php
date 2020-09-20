<?php

namespace Model;

use Controllers\MainController;
use View\WrongUserInputView;

class UserInputModel extends Model
{
    protected $youtubeName;

    /**
     * UserInputModel constructor.
     * @param MainController $controller
     * @param string $youtubeName
     */
    public function __construct(MainController $controller, string $youtubeName)
    {
        parent::__construct($controller);
        $this->checkYoutubeName($youtubeName, $controller);

    }

    public function checkYoutubeName($name, $controller)
    {
        $this->youtubeName = htmlspecialchars($name);

        if (iconv_strlen($name) > 150) {
            $wrongInputView = new WrongUserInputView($this->controller);
            $wrongInputView->output();
        } else {
            $controller->writeYoutubeData($this->youtubeName);
        }
    }

    /**
     * @return mixed
     */
    public function getYoutubeName()
    {
        return $this->youtubeName;
    }

    /**
     * @param mixed $youtubeName
     */
    public function setYoutubeName($youtubeName): void
    {
        $this->youtubeName = $youtubeName;
    }


}