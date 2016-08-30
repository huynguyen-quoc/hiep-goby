<?php

namespace App\Exceptions;

use Exception;
use Log;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {


        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        Log::error('*************** ERROR RENDER DATA **************************');

        if ($request->wantsJson())
        {
            Log::error('[ CODE ] '.  $e->getCode());
            Log::error('[ RESPONSE ] '. $e->getMessage());
            // Define the response
            $response = [
                'code' => $e->getCode(),
                'messages' => $e->getMessage()
            ];

            // If the app is in debug mode
            if (config('app.debug'))
            {
                // Add the exception class name, message and stack trace to response
                $response['exception'] = get_class($e); // Reflection might be better here
                $response['message'] = $e->getMessage();
                $response['trace'] = $e->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            if ($this->isHttpException($e))
            {
                // Grab the HTTP status code from the Exception
                $status = $e->getStatusCode();
            }


            Log::error('***************  ERROR RENDER DATA **************************');
            // Return a JSON response with the response array and status code
            return response()->json($response, $status);
        }
        Log::error('[ CODE ] '. $e->getCode());
        Log::error('[ RESPONSE ] '. $e->getMessage());
        Log::error('***************  ERROR RENDER DATA **************************');
        return parent::render($request, $e);
    }
}
