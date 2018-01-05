<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use function array_get;
use function redirect;
use function response;
use function route;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }


	/**
	 * Editing this class to support both user and customer
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param AuthenticationException  $exception
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
	    if($request->expectsJson()) {
	    	return response()->json(['error' => 'Unauthenticated.'], 401);
	    }

	    $guard = array_get($exception->guards(), 0);

	    switch ($guard)
	    {
		    case "customer":
		    	$login = "customer.login";
		    	break;

		    default:
		    	$login = "login";
		    	break;
	    }

	    return redirect()->guest(route($login));
    }
}
