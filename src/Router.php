<?php

namespace App;

use App\Exception\HttpException;
use InvalidArgumentException;
use JsonException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\PSR7Client;
use Spiral\RoadRunner\Worker;
use Throwable;

final class Router
{
    public static function handle(): void
    {
        $worker = new Worker(new StreamRelay(STDIN, STDOUT));
        $psr7 = new PSR7Client($worker);

        try {
            $env = App::getEnv();
        } catch (Throwable $e) {
            $psr7->getWorker()->error((string) $e);
            return;
        }

        try {
            while ($request = $psr7->acceptRequest()) {
                // jit debug, no autostart, see xdebug.ini
                if (isset($xdebug_session)) {
                    $psr7->getWorker()->stop();
                    return;
                }
                if (
                    'prod' !== $env
                    && (
                        array_key_exists('XDEBUG_SESSION', $request->getCookieParams())
                        || array_key_exists('XDEBUG_SESSION', $request->getAttributes())
                        || array_key_exists('XDEBUG_SESSION', $request->getQueryParams())
                        || array_key_exists('Xdebug_session', $request->getHeaders())
                    )
                ) {
                    /** @noinspection ForgottenDebugOutputInspection PhpComposerExtensionStubsInspection */
                    xdebug_break();
                    $xdebug_session = true;
                }
                // handle request
                try {
                    $response = self::dispatch($request);
                } catch (HttpException $e) {
                    /** @noinspection ForgottenDebugOutputInspection */
                    error_log((string) $e);
                    $response = 'prod' === $env
                        ? new Response\JsonResponse(['error' => $e->getMessage()], $e->getCode())
                        : self::exToResponce($e);
                } catch (Throwable $e) {
                    /** @noinspection ForgottenDebugOutputInspection */
                    error_log((string) $e);
                    $response = 'prod' === $env
                        ? new Response\EmptyResponse(500)
                        : self::exToResponce($e);
                }
                $psr7->respond($response);
            }
        } catch (Throwable $e) {
            $psr7->getWorker()->error((string) $e);
            return;
        }
    }

    public static function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        if ('POST' !== $request->getMethod()) {
            throw new HttpException(405);
        }
        $action = self::getAction($request);
        if (!class_exists($action)) {
            throw new HttpException(404);
        }
        return App::get($action)(self::parse($request));
    }

    public static function getAction(ServerRequestInterface $request): string
    {
        // /task/set -> \App\Action\TaskSet
        return '\\App\\Action\\' . str_replace('/', '', ucwords($request->getUri()->getPath(), '/'));
    }

    public static function parse(ServerRequestInterface $request): ServerRequestInterface
    {
        if ($request->getBody()->getSize()) {
            try {
                $json = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
                $request = $request->withParsedBody($json);
            } catch (JsonException | InvalidArgumentException $e) {
                throw new HttpException(400, 'Parcing body error', $e);
            }
        }
        return $request;
    }

    public static function exToArray(Throwable $e): array
    {
        return [
            'error' => [
                'class' => get_class($e),
                'msg' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ],
        ];
    }

    public static function exToResponce(Throwable $e): Response
    {
        return new Response\JsonResponse(
            static::exToArray($e),
            get_class($e) === HttpException::class ? $e->getCode() : 500,
            [],
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }
}
