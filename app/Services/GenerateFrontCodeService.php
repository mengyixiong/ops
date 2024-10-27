<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\GenerateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

/**
 * 生成后台代码
 */
class GenerateFrontCodeService
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

    private $apiTypeName;

    # 添加到数据库的数据
    private array $record = [

    ];
    /**
     * @var mixed|string
     */
    private mixed $prefix;
    /**
     * 功能名称
     */
    private string $featureName;

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
        ];
        foreach ($record as $field => $value) {
            if (in_array($field, $deleteFileFiles)) {
                $path = app_path() . $value;
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
        if (empty($params['path'])) {
            throw new ApiException('请输入路径');
        }
        $this->path        = $params['path'];
        $this->tableName   = $params['table_name'];
        $this->prefix      = $params['prefix'] ?? '';
        $this->featureName = Str::of($this->tableName)->after($this->prefix)->singular()->camel();
        $this->apiTypeName = Str::of($this->tableName);

        #  初始化数据表
        $this->initTable();
        return $this;
    }

    public function initIndex(): void
    {
        $tpl = file_get_contents(public_path('tpl/front/index.tpl'));

        /**
         * page.finance.currency.code
         */
        $tableColumns = [];
        foreach ($this->columns as $column) {
            if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                # 如果是enum类型,则需要特殊处理
                $enum = '';
                if ($column->DATA_TYPE == 'enum') {
                    $enum = "      render: row => {
        const hide: CommonType.YesOrNo = row.{$column->COLUMN_NAME};

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = \$t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
\n      }\n";
                }

                $tableColumn    = "    {
      key: '$column->COLUMN_NAME',
      title: \$t('page.{$this->path}.{$this->featureName}.{$column->COLUMN_NAME}'),
      align: 'center',
      minWidth: 80,
$enum";
                $tableColumn    .= "    },";
                $tableColumns[] = $tableColumn;
            }
        }
        $tpl = str_replace('{tableColumn}', implode("\n", $tableColumns), $tpl);
        $tpl = str_replace('{path}', $this->path, $tpl);
        $tpl = str_replace('{featureName}', $this->featureName, $tpl);

        file_put_contents(app_path('test\\') . 'index.vue', $tpl);

        dd(implode("\n", $tableColumns));
    }

    /**
     * 生成
     * @return true
     * @throws ApiException
     */

    public function generate()
    {

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

    private function initTable(): void
    {
        # 获取表结构
        $this->columns = DB::select("SELECT *
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'ops' AND TABLE_NAME = '$this->tableName' order by ORDINAL_POSITION ASC ;");

        # 已排除的字段
        $columnFields               = array_column($this->columns, 'COLUMN_NAME');
        $this->alreadyExcludeFields = array_filter($columnFields, function ($item) {
            return !in_array($item, $this->excluded);
        });

        # 基础名称
        $this->baseName = Str::of($this->tableName)->after($this->prefix)->singular()->studly();
    }
}
