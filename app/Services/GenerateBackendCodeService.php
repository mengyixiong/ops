<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Controllers\GenerateController;
use App\Models\GenerateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 生成后台代码
 */
class GenerateBackendCodeService
{
    # 表的所有字段
    protected array $columns = [];
    # 表名
    protected string $tableName = '';
    # 模型名
    protected string $modelName = '';
    # 控制器名
    private string $controllerName;
    # 逻辑类名
    private string $logicName;

    # 需要排除的字段
    private array $excluded = ['id', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    # 不需要生成规则的字段
    private array $alreadyExcludeFields = [];

    # 路径,比如: 生成到什么目录下面
    private string $path;

    # 基础命名空间,比如namespace App\Http\Controllers\$baseNamespace;
    private string $baseNamespace;

    # 基础命名,用来生成文件名(controller,logic) 比如 $baseNameController
    private string $baseName;
    private string $basePath = '\app';

    # 添加到数据库的数据
    private array $record = [

    ];

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }


    /**
     * 删除生成的文件, 删除后可以重新生成
     * @param $tableName :表名
     * @throws ApiException
     */
    public function delete($tableName): static
    {
        $record = DB::table('generate_records')->where('table_name', $tableName)->first();
        if (empty($record)) {
            throw new ApiException('生成记录不存在!');
        }

        # 删除文件
        $deleteFileFiles = [
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
        foreach ($record as $field => $value) {
            if (in_array($field, $deleteFileFiles)) {
                $path = base_path() . $value;
                $dir  = dirname($path);
                if (file_exists($path)) {
                    unlink($path);
                    if (isDirEmpty($dir)) {
                        rmdir($dir);
                    }
                }
            }
        }

        GenerateRecord::destroy($record->id);
        return $this;
    }

    /**
     * 生成文件时初始化参数
     * @param $params
     * @return $this
     * @throws ApiException
     */
    public function init($params = [])
    {
        if (empty($params['table_name'])) {
            throw new ApiException('请输入表名');
        }
        $this->tableName      = $params['table_name'];
        $this->modelName      = Str::of($this->tableName)->singular()->studly();
        $fullModelName        = "App\\Models\\" . $this->modelName;
        $prefix               = $params['prefix'] ?? '';
        $this->path           = $params['path'] ?? '';
        $this->tableName      = (new $fullModelName)->getTable();
        $this->baseName       = Str::of($this->tableName)->after($prefix)->singular()->studly();
        $this->controllerName = $this->baseName . 'Controller';
        $this->logicName      = $this->baseName . 'Logic';
        $this->baseNamespace  = $this->initNamespace();

        # 获取表结构
        $this->columns = DB::select("SELECT *
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'ops' AND TABLE_NAME = '$this->tableName' order by ORDINAL_POSITION ASC ;");

        # 已排除的字段
        $columnFields               = array_column($this->columns, 'COLUMN_NAME');
        $this->alreadyExcludeFields = array_filter($columnFields, function ($item) {
            return !in_array($item, $this->excluded);
        });
        return $this;
    }

    /**
     * 初始化基础命名空间
     */
    public function initNamespace()
    {
        $baseNamespace = "\\";
        $path          = explode("\\", $this->path);
        $camelArr      = [];
        foreach ($path as $item) {
            # 转换成大驼峰命名
            $camelArr[] = ucfirst(Str::camel($item));
        }
        $baseNamespace .= implode('\\', $camelArr);
        return $baseNamespace;
    }

    /**
     * 生成控制器
     * @return $this
     */
    public function initController()
    {
        $tpl          = file_get_contents(public_path('tpl/controller.tpl'));
        $tpl          = str_replace('{namespace}', $this->baseNamespace, $tpl);
        $tpl          = str_replace('{baseName}', $this->baseName, $tpl);
        $tpl          = str_replace('{varName}', Str::of($this->baseName)->camel()->toString(), $tpl);
        $tpl          = str_replace('{modelName}', $this->modelName, $tpl);
        $tpl          = str_replace('{controllerName}', $this->controllerName, $tpl);
        $tpl          = str_replace('{logicName}', $this->logicName, $tpl);
        $generatePath = $this->basePath . "\Http\Controllers{$this->baseNamespace}\\" . $this->controllerName . '.php';
//        file_put_contents($generatePath, $tpl);
        $this->record[] = [
            'type'    => 'controller',
            'path'    => $generatePath,
            'content' => $tpl
        ];
        return $this;
    }

    public function initLogic()
    {
        $queries        = [
        ];
        $tpl            = file_get_contents(public_path('tpl/logic.tpl'));
        $columnFields   = $this->alreadyExcludeFields;
        $actionFields   = array_map(function ($item) {
            return "'$item',";
        }, $columnFields);
        $columnFieldStr = '';
        foreach ($actionFields as $field) {
            $columnFieldStr .= "\n\t\t$field";
        }
        $tpl = str_replace('{namespace}', $this->baseNamespace, $tpl);
        $tpl = str_replace('{actionFields}', $columnFieldStr, $tpl);
        $tpl = str_replace('{modelName}', $this->modelName, $tpl);
        $tpl = str_replace('{logicName}', $this->logicName, $tpl);


        # 条件组装
        $where = '';
        foreach ($queries as $index => $query) {
            $tab = $index == 0 ? '' : "\t\t\t";
            switch ($query['type']) {
                case 'like':
                    $where .= <<<EOT
$tab ->when(!empty(\$this->request->{$query['field']}), function (Builder \$query) {
\t\t\t\t\$query->where('{$query['field']}', 'like', "%{\$this->request->{$query['field']}}%");
\t\t\t})\n
EOT;
                    break;
                case 'eq':
                    $where .= <<<EOT
$tab\->when(!empty(\$this->request->{$query['field']}), function (Builder \$query) {
\t\t\t\t\$query->where('{$query['field']}', "{\$this->request->{$query['field']}}");
\t\t\t})\n
EOT;
                    break;
            }
        }
        $tpl = str_replace('{where}', $where, $tpl);

        $generatePath = $this->basePath . "\Logics{$this->baseNamespace}\\" . $this->logicName . '.php';
//        file_put_contents($generatePath, $tpl);
        $this->record[] = [
            'type'    => 'logic',
            'path'    => $generatePath,
            'content' => $tpl
        ];
        return $this;
    }

    public function initRequest()
    {
        $this->generateAddRequest();
        $this->generateUpdateRequest();
        return $this;
    }

    private function generateAddRequest()
    {
        $tpl      = file_get_contents(public_path('tpl/AddRequest.tpl'));
        $rules    = [];
        $messages = [];
        foreach ($this->columns as $column) {
            if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                if ($column->IS_NULLABLE == 'NO') {
                    $rules[] = "\n\t\t\t'$column->COLUMN_NAME'=>'required'";
                    $msg     = "'$column->COLUMN_COMMENT 不能为空'";
                    if ($column->DATA_TYPE == 'enum') {
                        $msg = "'请选择 $column->COLUMN_COMMENT'";
                    }
                    $messages[] = "\n\t\t\t'$column->COLUMN_NAME.required'=>$msg";
                }
            }
        }
        $rules    = implode(",", $rules);
        $messages = implode(",", $messages);
        $tpl      = str_replace('{rules}', $rules, $tpl);
        $tpl      = str_replace('{messages}', $messages, $tpl);
        $tpl      = str_replace('{namespace}', $this->baseNamespace, $tpl);
        $tpl      = str_replace('{baseName}', $this->baseName, $tpl);

        $generatePath = $this->basePath . "\Http\Requests{$this->baseNamespace}\\{$this->baseName}\\" . 'AddRequest.php';
//        file_put_contents($generatePath, $tpl);
        $this->record[] = [
            'type'    => 'add_request',
            'path'    => $generatePath,
            'content' => $tpl
        ];
    }

    private function generateUpdateRequest()
    {
        $tpl = file_get_contents(public_path('tpl/UpdateRequest.tpl'));

        $rules    = [];
        $messages = [];
        foreach ($this->columns as $column) {
            if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                if ($column->IS_NULLABLE == 'NO') {
                    $rules[] = "\n\t\t\t'$column->COLUMN_NAME'=>'required'";
                    $msg     = "'$column->COLUMN_COMMENT 不能为空'";
                    if ($column->DATA_TYPE == 'enum') {
                        $msg = "'请选择 $column->COLUMN_COMMENT'";
                    }
                    $messages[] = "\n\t\t\t'$column->COLUMN_NAME.required'=>$msg";
                }
            }
        }
        $rules    = implode(",", $rules);
        $messages = implode(",", $messages);
        $tpl      = str_replace('{rules}', $rules, $tpl);
        $tpl      = str_replace('{messages}', $messages, $tpl);
        $tpl      = str_replace('{namespace}', $this->baseNamespace, $tpl);
        $tpl      = str_replace('{baseName}', $this->baseName, $tpl);

        $generatePath = $this->basePath . "\Http\Requests{$this->baseNamespace}\\{$this->baseName}\\" . 'UpdateRequest.php';

//        file_put_contents($generatePath, $tpl);
        $this->record[] = [
            'type'    => 'update_request',
            'path'    => $generatePath,
            'content' => $tpl
        ];
    }

    /**
     * 生成
     * @return true
     * @throws ApiException
     */

    public function generate()
    {
        return $this->record;
        DB::beginTransaction();
        try {
            $data               = array_column($this->record, 'path', 'type');
            $data['table_name'] = $this->tableName;
            GenerateRecord::create($data);

            foreach ($this->record as $item) {
                $path = app_path() . $item['path'];
                $dir  = dirname($path);
                if (!is_dir($dir)) {
                    mkdir($dir, 777);
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
}
