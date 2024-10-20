<?php

namespace App\Traits;


trait Response
{

    public function success($data = null, $message = 'success')
    {
        return response()->json(
            [
                'code'    => 200,
                'msg' => $message,
                'data'    => $data
            ]
        );
    }

    public function succOk($message = 'success')
    {
        return $this->success(null, $message);
    }

    public function succData($data)
    {
        return $this->success($data);
    }

    public function succPage($data)
    {
        return $this->success([
            'page'  => $data->currentPage(),
            'total' => $data->total(),
            'limit' => $data->perPage(),
            'data'  => $data->items(),
        ]);
    }

    public function error($code = 400, $message = 'error', $data = null)
    {
        return response()->json(
            [
                'code'    => $code,
                'msg' => $message,
                'data'    => null,
            ]
        );
    }

}
