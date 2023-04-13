<?php

namespace App\Middleware;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class CorsMiddleWare
 *
 * This is the middleware class to configure and add CORS headers
 *
 * @package App\Middleware
 */
class CorsMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($request instanceof ServerRequest && $response instanceof Response) {
            $response = $response->cors($request)
                ->allowOrigin(['*'])
                ->allowMethods(['*'])
                ->allowHeaders(['x-xsrf-token', 'Origin', 'Content-Type', 'X-Auth-Token'])
                ->allowCredentials(['true'])
                ->exposeHeaders(['Link'])
                ->maxAge(300)
                ->build();
            if (strtoupper($request->getMethod()) === 'OPTIONS') {
                $response = $response->withStatus(200);
            }
        }
        return $response;
    }
}
