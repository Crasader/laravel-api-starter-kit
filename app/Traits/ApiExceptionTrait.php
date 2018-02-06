<?php

namespace App\Traits;

use App\Exceptions\ApiResponseExceptionHandler;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait ApiExceptionTrait
{
    use ApiResponseTrait;
    
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Exception $e)
    {
        #echo get_class($e);
        #exit();
        switch (true) {
            
            case $this->isModelNotFoundException($e):
                $response = $this->responseNotFound();
                break;
            
            case $this->isRouteNotFoundException($e):
                $response = $this->responseWithError(trans('notfound.page'), 404);
                break;
            
            case $this->isAuthenticationException($e):
                $response = $this->responseWithError(trans('auth.unauthenticated'), 401);
                break;
            
            case $this->isApiResponseException($e):
                $response = $this->responseWithError($e->getMessage(), 500);
                break;
            
            case $this->isTokenBlacklistedException($e):
                $response = $this->responseWithError(trans('auth.token.blacklisted'));
                break;
            
            case $this->isTokenExpiredException($e) :
                $response = $this->responseWithError(trans('auth.token.expired'), 401);
                break;
            
            case $this->isTokenInvalidException($e):
                $response = $this->responseInvalidToken();
                break;
            
            case $this->isUnauthorizedHttpException($e):
                $response = $this->responseWithError(trans('auth.unauthorized'));
                break;
            
            case $this->isAuthorizationException($e):
                $response = $this->responseWithError(trans('auth.unauthorized'), 401);
                break;
            
            case $this->isHttpException($e):
                $response = $this->responseWithError($e->getMessage());
                break;
            
            case $this->isQueryException($e):
                $response = $this->responseWithErrorTrace(trans('query.failed'), $e->getMessage());
                break;
            
            case $this->isFieldValidationException($e):
                $response = $this->response([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'errors'  => $e->errors()
                ]);
                break;
            
            default:
                $trace    = "Line: {$e->getLine()} File: {$e->getFile()} Message: {$e->getMessage()}";
                $response = $this->responseWithErrorTrace('General Exception.', $trace);
                break;
            
        }
        
        return $response;
    }
    
    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }
    
    /**
     * Determines if the given exception is a Route not found
     *
     * @param Exception $e
     * @return bool
     */
    protected function isRouteNotFoundException(Exception $e)
    {
        return $e instanceof NotFoundHttpException;
    }
    
    /**
     * Determines if the given exception is an Authentication is needed.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isAuthenticationException(Exception $e)
    {
        return $e instanceof AuthenticationException;
    }
    
    /**
     * Determines if the given exception is from api response and display proper message
     *
     * @param Exception $e
     * @return bool
     */
    protected function isApiResponseException(Exception $e)
    {
        return $e instanceof ApiResponseExceptionHandler;
    }
    
    /**
     * Token is blacklisted or invalidated
     *
     * @param Exception $e
     * @return bool
     */
    protected function isTokenBlacklistedException(Exception $e)
    {
        return $e instanceof TokenBlacklistedException;
    }
    
    /**
     * Determines if token has expired
     *
     * @param Exception $e
     * @return bool
     */
    protected function isTokenExpiredException(Exception $e)
    {
        return $e instanceof TokenExpiredException;
    }
    
    /**
     * Determines if token is invalid
     *
     * @param Exception $e
     * @return bool
     */
    protected function isTokenInvalidException(Exception $e)
    {
        return $e instanceof TokenInvalidException;
    }
    
    /**
     * Generate if token is blacklisted
     *
     * @param Exception $e
     * @return bool
     */
    protected function isUnauthorizedHttpException(Exception $e)
    {
        return $e instanceof UnauthorizedHttpException;
    }
    
    /**
     * Determines if if a authorization exception occur
     *
     * @param Exception $e
     * @return bool
     */
    protected function isAuthorizationException(Exception $e)
    {
        return $e instanceof AuthorizationException;
    }
    
    /**
     * Determines any other http exception
     *
     * @param Exception $e
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
    }
    
    /**
     * Determines if a exception is cause by the sql query
     *
     * @param Exception $e
     * @return bool
     */
    protected function isQueryException(Exception $e)
    {
        return $e instanceof QueryException;
    }
    
    /**
     * Determine if a request has failed the form validation
     *
     * @param Exception $e
     * @return bool
     */
    protected function isFieldValidationException(Exception $e)
    {
        return $e instanceof ValidationException;
    }
    
    /**
     * Determines if a method is allowed on the http request
     *
     * @param Exception $e
     * @return bool
     */
    protected function isMethodNotAllowedHttpException(Exception $e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }
    
}