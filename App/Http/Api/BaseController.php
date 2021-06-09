<?php


namespace App\Http\Api;


use Laravel\Lumen\Routing\Controller;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Otus Course Api",
 *         description="This is simple project to do course's tasks",
 *         @OA\Contact(
 *             email="sneqastk@gmail.com"
 *         ),
 *     ),
 *     @OA\ExternalDocumentation(
 *         description="Find out more about Swagger",
 *         url="http://swagger.io"
 *     )
 * )
 */

abstract class BaseController extends Controller
{

}