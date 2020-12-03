<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * @OA\Info(
     *      version="0.0.1",
     *      title="OpenApi Documentation for hw16 project",
     *      description="docs for hw16 API",
     *      @OA\Contact(
     *          email="admin@leffo.online"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="hw16 API Server"
     * )

     *
     * @OA\Tag(
     *     name="hw16",
     *     description="API Endpoints of Projects"
     * )
     */
}
