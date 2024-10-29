<?php

namespace App\Http\Controllers;


use App\Exceptions\ApiException;
use App\Models\GenerateRecord;
use App\Services\GenerateBackendCodeService;
use App\Services\GenerateFrontCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenerateController extends BaseController
{
    public function generate()
    {
        $isTest = request()->input('is_test', false);
        $params = request()->only([
            'module',
            'path',
            'front_path',
            'table_name',
            'prefix',
            'is_test'
        ]);

        $validator = Validator::make($params,
            [
                'module'     => 'required',
                'path'       => 'required',
                'front_path' => 'required',
                'table_name' => 'required',
            ],
            [
                'module.required'     => '模块名必填',
                'path.required'       => '后端代码生成路径必填',
                'front_path.required' => '前端代码生成路径必填',
                'table_name.required' => '表名必填',
            ]
        );
        $validator->validate();

        $backendRecords = app(GenerateBackendCodeService::class)
            ->init([
                'path'       => $params['path'],
                'table_name' => $params['table_name'],
                'prefix'     => $params['prefix'],
            ])
            ->initController()
            ->initLogic()
            ->initRequest()
            ->generate();
        /**
         * 'module'     => 'tool',
         * 'path'       => 'tool/code-generate',
         * 'table_name' => 'generate_records',
         * 'prefix'     => '',
         */
        $frontRecords = app(GenerateFrontCodeService::class)
            ->init([
                'module'     => $params['module'],
                'path'       => $params['front_path'],
                'table_name' => $params['table_name'],
                'prefix'     => $params['prefix'],
            ])
            ->initIndex()
            ->initApiDts()
            ->initModule()
            ->initLang()
            ->initServiceApi()
            ->generate();

        $records = array_merge($backendRecords, $frontRecords);

        DB::beginTransaction();
        try {
            if (!$isTest) {
                $data               = array_column($records, 'path', 'type');
                $data['table_name'] = $params['table_name'];
                GenerateRecord::create($data);
            }
            foreach ($records as $item) {
                $path = base_path() . $item['path'];
                $file = basename($path);
                if ($isTest) {
                    $path = app_path('test/') . $file;
                }
                $dir = dirname($path);
//                if ($item['type'] == 'add_request'){
//                    mkdir($dir, 777,true);
//                    dd($dir);
//                }
                if (!is_dir($dir)) {
                    mkdir($dir, 777,true);
                }
                file_put_contents($path, $item['content']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }
        return true;
    }

    public function del(string $tableName)
    {
        app(GenerateBackendCodeService::class)->delete('generate_records');
    }

}
