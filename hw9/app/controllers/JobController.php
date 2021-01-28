<?php

namespace app\controllers;

use Swagger\Annotations as SWG;
use yii\rest\ActiveController;

/**
 * @SWG\Swagger (
 *     basePath="/jobs",
 *     produces={"application/json","application/xml"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="Simple API with RabbitMQ")
 * )
 */
class JobController extends ActiveController
{
    public $modelClass = 'app\models\Job';
}