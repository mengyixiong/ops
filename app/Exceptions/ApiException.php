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

    /**
     * 渲染异常为HTTP响应。
     */
    public function render(Request $request)
    {
        // 检查是否为API请求，返回JSON响应
        if ($request->expectsJson()) {
            return $this->error($this->getCode(),$this->getMessage());
        }

        // 其他情况返回默认视图
        return parent::render($request);
    }
}
