<?php

namespace Src\Events;

use Src\DTO\ResetRowsDTO;
use Src\Entities\Play;

class RowResetEvent extends BaseEvent
{
    private ?Play $play = null;
    private ?ResetRowsDTO $resetRowsDto = null;

    /**
     * @return Play
     */
    public function getPlay(): Play
    {
        return $this->play;
    }

    /**
     * @param Play $play
     */
    public function setPlay(Play $play): void
    {
        $this->play = $play;
    }

    /**
     * @return ResetRowsDTO
     */
    public function getResetRowsDto(): ResetRowsDTO
    {
        return $this->resetRowsDto;
    }

    /**
     * @param ResetRowsDTO $resetRowsDto
     */
    public function setResetRowsDto(ResetRowsDTO $resetRowsDto): void
    {
        $this->resetRowsDto = $resetRowsDto;
    }
}