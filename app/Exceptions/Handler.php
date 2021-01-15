<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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

    public function render($request, Throwable $e)
    {
        $request->headers->set('Accept', 'application/json');

        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Entry for ' . str_replace('App\\Models\\', '', $e->getModel()) . ' not found'], Response::HTTP_NOT_FOUND);
        } else if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_METHOD_NOT_ALLOWED);
        } else if ($e instanceof RouteNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Route does not exists.'], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $e);
    }
}
