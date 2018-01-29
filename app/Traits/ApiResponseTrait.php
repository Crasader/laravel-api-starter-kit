<?php namespace App\Traits;


trait ApiResponseTrait
{
    /**
     * Record not found response
     *
     * @param string $message
     * @return mixed
     */
    public function responseNotFound($message = 'RECORD_NOT_FOUND')
    {
        return $this->responseWithError($message, 404);
    }
    
    /**
     * General error response
     *
     * @param     $message
     * @param int $code
     * @return mixed
     */
    public function responseWithError($message, $code = 400)
    {
        return $this->response([
            'status'  => 'error',
            'message' => $message,
        ], $code);
    }
    
    /**
     * General respond
     *
     * @param       $data
     * @param int   $code
     * @param array $headers
     * @return mixed
     */
    public function response($data, $code = 200, $headers = [])
    {
        return response()->json($data, $code, $headers);
    }
    
    /**
     * Display error with file trace
     *
     * @param $message
     * @param $trace
     * @return mixed
     */
    public function responseWithErrorTrace($message, $trace)
    {
        return $this->response([
            'status'  => 'error',
            'message' => $message,
            'trace'   => $trace
        ], 500);
    }
    
    /**
     * Invalid Token Response
     *
     * @param string $message
     * @return mixed
     */
    public function responseInvalidToken($message = 'INVALID_TOKEN')
    {
        return $this->responseWithError($message, 401);
    }
    
    /**
     * General code error response
     * @param string $message
     * @return mixed
     */
    public function responseCodeError($message = 'CODE_ERROR')
    {
        return $this->responseWithError($message, 500);
    }
    
    /**
     * General success response
     *
     * @param $message
     * @return mixed
     */
    public function responseWithSuccess($message)
    {
        return $this->response([
            'status'  => 'success',
            'message' => $message,
        ], 200);
    }
    
}