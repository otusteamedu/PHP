<?php

namespace App;

use App\Exceptions\BadRequestException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\UnprocessableEntityException;
use App\Services\Request;

class Main
{
    public function run(): void
    {
        try {
            Request::getInstance()->process();
        } catch (UnprocessableEntityException $e) {
            http_response_code(422);
            echo $e->getMessage();
        } catch (MethodNotAllowedException $e) {
            http_response_code(405);
            echo $e->getMessage();
        } catch (BadRequestException $e) {
            http_response_code(400);
            echo $e->getMessage();
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}
