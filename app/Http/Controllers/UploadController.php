<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends BaseController
{
    public function uploadAvatar(Request $request)
    {
        // 验证上传的文件
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048', // 设置上传文件类型及大小限制
        ]);

        // 获取上传的文件
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // 生成文件存储路径
            $path = $file->store('uploads', 'public'); // 存储到 public/uploads 目录

            return  $this->succData([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['message' => 'File upload failed'], 400);
    }
}
