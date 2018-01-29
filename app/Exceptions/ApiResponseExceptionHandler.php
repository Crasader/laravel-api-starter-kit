<?php

namespace App\Exceptions;

use Exception;

class ApiResponseExceptionHandler extends Exception
{
    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    public $response;
    
    /**
     * Create a new exception instance.
     *
     * @param string                                      $message
     * @param  \Symfony\Component\HttpFoundation\Response $response
     */
    public function __construct($message = 'An error occurred', $response = null)
    {
        parent::__construct($message);
        
        $this->response = $response;
    }
    
    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
