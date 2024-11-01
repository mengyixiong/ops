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
    # 需要排除的字段
    private array $excluded = ['id', 'created_by', 'created_at', 'updated_by', 'updated_at'];
    # 不需要生成规则的字段
    private array $alreadyExcludeFields = [];
    # 路径,比如: 生成到什么目录下面
    private string $path;
    # 基础命名,用来生成文件名(controller,logic) 比如 $baseNameController
    private string $basePath = '';
    #大驼峰模块名
    private string $studlyModule;
    #模块名
    private string $module;
    # 添加到数据库的数据
    private array $record = [

    ];
    # 表前缀
    private string $prefix;
    # 功能名称
    private string $featureName;
    # 表注释
    private string $tableComment;


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
        if (empty($params['module'])) {
            throw new ApiException('请输入模块名');
        }
        if (empty($params['table_name'])) {
            throw new ApiException('请输入表名');
        }
        if (empty($params['path'])) {
            throw new ApiException('请输入路径');
        }
        $this->module       = $params['module'];
        $this->path         = $params['path'];
        $this->tableName    = $params['table_name'];
        $this->prefix       = $params['prefix'] ?? '';
        $this->featureName  = Str::of($this->tableName)->after($this->prefix)->singular()->studly();
        $this->module       = Str::of($this->module)->camel();
        $this->studlyModule = Str::of($this->module)->studly();
        $this->basePath     = '/template/ops-admin/src/';

        #  初始化数据表
        $this->initTable();
        return $this;
    }

    public function initIndex()
    {
        $tpl = file_get_contents(public_path('tpl/front/index.tpl'));

        /**
         * page.finance.currency.code
         */
        $langPrefix   = "$this->module.$this->featureName";
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
      title: \$t('page.$langPrefix.{$column->COLUMN_NAME}'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
$enum";
                $tableColumn    .= "    },";
                $tableColumns[] = $tableColumn;
            }
        }
        $tpl          = str_replace('{tableColumn}', implode("\n", $tableColumns), $tpl);
        $tpl          = str_replace('{path}', $this->path, $tpl);
        $tpl          = str_replace('{module}', $this->module, $tpl);
        $tpl          = str_replace('{langPrefix}', $langPrefix, $tpl);
        $featureName  = Str::of($this->featureName)->snake()->toString();
        $tpl          = str_replace('{featureName}', $featureName, $tpl);
        $featureName  = Str::of($this->featureName)->snake()->replace('_', '-')->toString();
        $generatePath = $this->basePath . 'views/' . $this->path . '/' . $featureName . '/index.vue';

        $this->record[] = [
            'type'    => 'index_vue',
            'path'    => $generatePath,
            'content' => $tpl
        ];
        return $this;
    }

    /**
     * 初始化api.d.ts
     */
    public function initApiDts()
    {
        $originApiDTsPath = base_path("template/ops-admin/src/typings/" . (Str::of($this->module)->camel()) . ".d.ts");
        if (file_exists($originApiDTsPath)) {
            $tpl                 = file_get_contents(public_path('tpl/front/api.d.tpl'));
            $originApiDTsFile    = file_get_contents(base_path('template/ops-admin/src/typings/finance.d.ts'));
            $originApiDTsFileStr = substr($originApiDTsFile, 0, strrpos($originApiDTsFile, '}'));
            $tpl                 = $originApiDTsFileStr . "\n" . $tpl;
        } else {
            $tpl = file_get_contents(public_path('tpl/front/full.api.d.tpl'));
        }

        $apiColumns = [];
        foreach ($this->columns as $column) {
            if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                $tableColumn  = "\t  $column->COLUMN_NAME: string;";
                $apiColumns[] = $tableColumn;
            }
        }

        $tpl          = str_replace('{featureName}', $this->featureName, $tpl);
        $tpl          = str_replace('{module}', $this->studlyModule, $tpl);
        $tpl          = str_replace('{apiColumns}', implode("\n", $apiColumns), $tpl);
        $tpl          .= "}";
        $generatePath = $this->basePath . 'typings/' . $this->module . ".d.ts";

        $this->record[] = [
            'type'    => 'api_type',
            'path'    => $generatePath,
            'content' => $tpl
        ];
        return $this;
    }

    public function initModule()
    {
        $this->initSearchForm();
        $this->initOperateDrawer();
        return $this;
    }

    public function initSearchForm()
    {
        $tpl          = file_get_contents(public_path('tpl/front/modules/search-form.tpl'));
        $tpl          = str_replace('{featureName}', $this->featureName, $tpl);
        $tpl          = str_replace('{module}', $this->studlyModule, $tpl);
        $featureName  = Str::of($this->featureName)->snake()->replace('_', '-')->toString();
        $generatePath = $this->basePath . 'views/' . $this->path . '/' . $featureName . '/modules/search-form.vue';

        $this->record[] = [
            'type'    => 'search_form',
            'path'    => $generatePath,
            'content' => $tpl
        ];
    }

    public function initOperateDrawer()
    {
        $tpl = file_get_contents(public_path('tpl/front/modules/operate-drawer.tpl'));
        $tpl = str_replace('{featureName}', $this->featureName, $tpl);
        $tpl = str_replace('{studlyModule}', $this->studlyModule, $tpl);
        $tpl = str_replace('{module}', $this->module, $tpl);

        $langPrefix         = "page.$this->module.$this->featureName";
        $formColumns        = [];
        $validateFields     = [];
        $validateFieldsRule = [];
        $formItems          = [];
        foreach ($this->columns as $column) {
            if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                $tableColumn   = "\t$column->COLUMN_NAME: '',";
                $formColumns[] = $tableColumn;

                if ($column->IS_NULLABLE == 'NO') {
                    $validateFields[]     = "'$column->COLUMN_NAME'";
                    $validateFieldsRule[] = "  $column->COLUMN_NAME: defaultRequiredRule,";
                }

                # 表单条目
                if (str_contains($column->COLUMN_NAME, 'is_')) {
                    $formItems[] = "        <NFormItem :label=\"\$t('$langPrefix.$column->COLUMN_NAME')\" path=\"$column->COLUMN_NAME\">
          <NSwitch v-model:value=\"model.$column->COLUMN_NAME\" checked-value=\"Y\" unchecked-value=\"N\">
          </NSwitch>
        </NFormItem>";
                    continue;
                }
                $formItems[] = "        <NFormItem :label=\"\$t('$langPrefix.$column->COLUMN_NAME')\" path=\"$column->COLUMN_NAME\">
          <NInput v-model:value=\"model.$column->COLUMN_NAME\" :placeholder=\"\$t('$langPrefix.form.$column->COLUMN_NAME')\" />
        </NFormItem>";
            }
        }

        $tpl          = str_replace('{formColumns}', implode("\n", $formColumns), $tpl);
        $tpl          = str_replace('{validateFields}', implode(" | ", $validateFields), $tpl);
        $tpl          = str_replace('{validateFieldsRule}', implode("\n", $validateFieldsRule), $tpl);
        $tpl          = str_replace('{formItems}', implode("\n", $formItems), $tpl);
        $featureName  = Str::of($this->featureName)->snake()->replace('_', '-')->toString();
        $generatePath = $this->basePath . 'views/' . $this->path . '/' . $featureName . '/modules/operate-drawer.vue';
        $tpl          = str_replace('{apiFileName}', Str::of($this->featureName)->snake()->toString(), $tpl);

        $this->record[] = [
            'type'    => 'operate_drawer',
            'path'    => $generatePath,
            'content' => $tpl
        ];
    }


    private array $langs = [
        'zh-cn' => 'zh',
    ];

    /**
     * 初始化语言包
     */
    public function initLang()
    {
        $endSymbol = "  }\n};";
        foreach ($this->langs as $lang) {
            $langFilePath = base_path("template/ops-admin/src/locales/langs/$lang/$this->module.ts");

            if (file_exists($langFilePath)) {
                $tpl         = file_get_contents(public_path('tpl/front/langs/lang.tpl'));
                $langFile    = file_get_contents($langFilePath);
                $langFileStr = substr($langFile, 0, strrpos($langFile, $endSymbol));
                $tpl         = $langFileStr . "\n" . $tpl;
            } else {
                $tpl = file_get_contents(public_path('tpl/front/langs/full.lang.tpl'));
            }

            $langColumns      = [];
            $formValidateTips = [];
            foreach ($this->columns as $column) {
                if (in_array($column->COLUMN_NAME, $this->alreadyExcludeFields)) {
                    $tableColumn   = "\t\t$column->COLUMN_NAME: '$column->COLUMN_COMMENT',";
                    $langColumns[] = $tableColumn;
                    if ($column->COLUMN_TYPE == 'enum' || str_contains($column->COLUMN_NAME, '_id')) {
                        $formValidateTips[] = "\t\t\t$column->COLUMN_NAME: '请选择 $column->COLUMN_COMMENT',";
                    } else {
                        $formValidateTips[] = "\t\t\t$column->COLUMN_NAME: '请输入 $column->COLUMN_COMMENT',";
                    }
                }
            }

            $tpl          = str_replace('{featureName}', $this->featureName, $tpl);
            $tpl          = str_replace('{module}', $this->module, $tpl);
            $tpl          = str_replace('{langColumns}', implode("\n", $langColumns), $tpl);
            $tpl          = str_replace('{formValidateTips}', implode("\n", $formValidateTips), $tpl);
            $tpl          = str_replace('{title}', $this->tableComment, $tpl);
            $tpl          .= "$endSymbol";
            $generatePath = $this->basePath . "locales/langs/$lang/" . $this->module . ".ts";

            $this->record[] = [
                'type'    => "lang_$lang",
                'path'    => $generatePath,
                'content' => $tpl
            ];

        }
        return $this;
    }


    /**
     * 初始化api请求路由
     */
    public function initServiceApi()
    {
        $tpl            = file_get_contents(public_path('tpl/front/service_api.tpl'));
        $featureName    = Str::of($this->featureName)->camel()->toString();
        $tpl            = str_replace('{featureName}', $featureName, $tpl);
        $tpl            = str_replace('{module}', $this->module, $tpl);
        $tpl            = str_replace('{studlyModule}', $this->studlyModule, $tpl);
        $featureName    = Str::of($this->featureName)->snake()->toString();
        $generatePath   = $this->basePath . "service/api/$this->module/" . $featureName . ".ts";
        $this->record[] = [
            'type'    => "service_api",
            'path'    => $generatePath,
            'content' => $tpl
        ];
        return $this;
    }

    /**
     * 生成
     * @return true
     * @throws ApiException
     */

    public function generate()
    {
        return $this->record;
//        dd(...array_column($this->record,'type'));
        dd(...$this->record);
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
        # 获取表注释
        $tableComment = DB::select("SELECT TABLE_COMMENT
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'ops' AND TABLE_NAME = '$this->tableName'");
        if (empty($tableComment)) {
            throw new ApiException("表名不存在");
        }
        $this->tableComment = $tableComment[0]->TABLE_COMMENT;
        $this->tableComment = str_replace('表', '', $this->tableComment);

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
