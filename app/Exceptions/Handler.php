<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if ($request->wantsJson() || $request->ajax() || \str_contains($request->route()->getPrefix(), 'api')) {
            $statusCode = ($e instanceof HttpExceptionInterface)
                ? $e->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            $headers = ($e instanceof HttpExceptionInterface)
                ? $e->getHeaders()
                : [];

            $body = [
                'meta' => [
                    'code'    => $statusCode,
                    'message' => $e->getMessage(),
                ]
            ];

            if ($e instanceof ValidationException) {
                $body['errors'] = $e->errors();
                $body['meta']['message'] = 'Invalid request parameters.';
                $body['meta']['code'] = Response::HTTP_BAD_REQUEST;
                $statusCode = Response::HTTP_BAD_REQUEST;
            }

            return response()->json($body, $statusCode, $headers);
        }

        return parent::render($request, $e);
    }
}
