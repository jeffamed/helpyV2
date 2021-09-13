<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponseTrait;
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

        $this->renderable(function (Throwable $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    public function handleException($request, Exception $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);
            } else if($exception instanceof NotFoundHttpException){
                //$model = strtolower(class_basename($exception->getModel()));
                return $this->errorResponse("Don't exist info related with the data send", 404);
            }
        }
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        $error = $e->validator->errors()->getMessages();

        return $request->expectsJson()
                    ? $this->errorResponse($error, 422) 
                    : $this->invalid($request, $e);
    }
}
