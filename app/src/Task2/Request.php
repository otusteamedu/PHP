<?php
namespace Otus\HW11\Task2;

use \Otus\HW11\Task2;

class Request
{
    protected $params;
    protected $conditions;
    protected $event;

    /**
     * Expect $_REQUEST
     *
     * Request constructor.
     * @param array $request
     */
    public function __construct(array $request)
    {
        // --- Params
        if ( !is_null($request['params']) ) {
            $this->params = new \DS\Vector();
            $arParams = explode(';', strip_tags($request['params']));

            foreach ($arParams as $param) {
                $this->params->push(new Task2\Param($param));
            }
        }

        // --- Conditions
        if ( !is_null($request['conditions']) ) {
            $this->conditions = new \DS\Vector();
            $arConditions = explode(';', strip_tags($request['conditions']));

            foreach ($arConditions as $condition) {
                $this->conditions->push(new Task2\Param($condition));
            }
        }

        // --- Event
        if ( !is_null($request['event']) ) {
            $this->event = new Task2\Event(
                intval($request['priority']),
                $request['event']
            );
        }

    }


    /**
     * @return \DS\Vector
     */
    public function getParams(): \DS\Vector
    {
        return $this->params;
    }


    /**
     * @return \DS\Vector
     */
    public function getConditions(): \DS\Vector
    {
        return $this->conditions;
    }


    /**
     * @return Event
     */
    public function getEvent(): Task2\Event
    {
        return $this->event;
    }

}
