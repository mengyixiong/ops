<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刷新数据库结构和数据';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        # Step 1: 运行数据库迁移
        $this->info("Running migrations...");
        Artisan::call('migrate:refresh');
        $this->line(Artisan::output());  // 输出迁移的结果

        # 数据库信息
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');

        # Step 2: 还原数据
        # 获取最新的备份
        $backupDir        = storage_path('backups');
        $backupFiles      = scandir($backupDir);
        $latestBackup     = null;
        $latestBackupTime = 0;
        foreach ($backupFiles as $file) {
            $filePath = $backupDir . '/' . $file;
            if (is_file($filePath)) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $fileTime = strtotime(str_replace(["{$database}_","_"],'',$fileName));
                if ($fileTime > $latestBackupTime) {
                    $latestBackup     = $filePath;
                    $latestBackupTime = $fileTime;
                }
            }
        }
        if (!$latestBackup) {
            $this->error('没有找到备份文件');
            return;
        }

        # 执行还原数据库
        $this->info('开始还原数据库');
        $this->info('备份文件：' . $latestBackup);
        $this->info('开始还原数据库');
        $command = "mysql -u$username -p$password -h$host $database < {$latestBackup}";
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info('数据库刷新成功');
        } else {
            $this->error('数据库刷新失败');
        }
    }
}
