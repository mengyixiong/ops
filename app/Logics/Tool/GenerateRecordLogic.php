<?php

namespace App\Logics\Tool;

use App\Exceptions\ApiException;
use App\Logics\BaseLogic;
use App\Models\GenerateRecord;
use App\Services\GenerateBackendCodeService;
use App\Services\GenerateFrontCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenerateRecordLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
		'table_name',
		'controller',
		'logic',
		'add_request',
		'update_request',
		'index_vue',
		'api_type',
		'search_form',
		'operate_drawer',
		'lang_zh',
		'service_api',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = GenerateRecord::query()

            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert(): void
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

        # 后端生成记录
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

        # 前端生成记录
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
    }

    /**
     * 修改
     */
    public function update($request, GenerateRecord $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(GenerateRecord $model): void
    {
        app(GenerateBackendCodeService::class)->delete($model->table_name);

    }

}
