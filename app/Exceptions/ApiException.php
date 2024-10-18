<?php

namespace App\Exceptions;

use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;

class ApiException extends Exception
{
    use Response;

    protected $message;
    protected $code;

    /**
     * 创建一个新的异常实例。
     */
    public function __construct($message = "自定义异常错误", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
