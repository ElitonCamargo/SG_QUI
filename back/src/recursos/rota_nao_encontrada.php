<?php
use Psr\Http\Message\ServerRequestInterface as Request;


$rotaNaoEncontrada = $app->addErrorMiddleware(true, true, true);
$rotaNaoEncontrada->setDefaultErrorHandler(function (Request $request, Throwable $exception, bool $displayErrorDetails) use ($app) {
    $statusCode = $exception->getCode() ?: 500;
    $errorData = [
        'error' => [
            'message' => $exception->getMessage(),
            'code' => $statusCode
        ]
    ];
    
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(json_encode($errorData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    
    return $response->withStatus($statusCode)
        ->withHeader('Content-Type', 'application/json');
});