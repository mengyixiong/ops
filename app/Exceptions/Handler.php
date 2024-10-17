<?php

namespace App\Exceptions;

use App\Traits\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    use Response;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    /**
     * 忽略报告的异常
     */
    protected $dontReport = [
        ApiException::class,
        ModelNotFoundException::class,
    ];

    public function report(Throwable $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }
        $request = request(); // 获取当前请求
        $url     = $request->fullUrl(); // 获取完整的URL

        // 记录URL和异常信息
        Log::error($e->getMessage(), [
            'url'       => $url,
            'method'    => $request->method(),
            'input'     => $request->all(), // 可选：记录请求输入数据
            'exception' => $e,
        ]);
    }

    public function render($request, Throwable $e)
    {
        # 记录不存在异常
        if ($e instanceof ModelNotFoundException) {
            $name = $e->getModel()::$name; # 获取模型的类名
            $ids  = implode(', ', $e->getIds()); # 获取找不到的ID
            return $this->error(404, "{$name}为 [{$ids}] 的记录不存在");
        }

        return $this->error(500, $e->getMessage());
    }
}
