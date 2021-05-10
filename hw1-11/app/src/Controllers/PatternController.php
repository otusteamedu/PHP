<?php
namespace Src\Controllers;

use Klein\Request;
use Src\DB\Connection;
use Src\Patterns\ActiveRecord\Employee;
use Src\Patterns\DataMapper\FilmMapper;

/**
 * Class PatternController
 *
 * @package Src\Controllers
 */
class PatternController
{
    /**
     * @param \Klein\Request $request
     *
     * @return string
     */
    public function getRecordsDataMapper(Request $request): string
    {
        $limit = (int)$request->paramsGet()->get('limit');
        $offset = (int)$request->paramsGet()->get('offset');
        $pdo = Connection::instance();
        $dataMapper = new FilmMapper($pdo);
        $collection = $dataMapper->getRecords($limit, $offset);

        return $this->getResult($collection);
    }

    /**
     * @param \Klein\Request $request
     *
     * @return string
     */
    public function getRecordsActiveRecord(Request $request): string
    {
        $limit = (int)$request->paramsGet()->get('limit');
        $offset = (int)$request->paramsGet()->get('offset');
        $pdo = Connection::instance();
        $activeRecord = new Employee($pdo);
        $collection = $activeRecord->getRecords($limit, $offset);

        return $this->getResult($collection);
    }

    /**
     * @param $collection
     *
     * @return string
     */
    private function getResult($collection): string
    {
        if (is_null($collection)) {
            $records = [];
        } else {
            $records = $collection->toArray();
        }

        return \GuzzleHttp\json_encode(
            [
                'result' => 'success',
                'data' => $records,
            ]
        );
    }
}