<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatabaseDataBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '备份数据库数据';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * 忽略表
         */
        $ignoreTables = [
            'migrations',
            'telescope_entries_tags',
            'telescope_entries',
            'telescope_monitoring',
            'personal_access_tokens',
            'password_reset_tokens',
            'failed_jobs',
        ];

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');

        foreach ($ignoreTables as &$table) {
            $table = "--ignore-table=$database.$table";
        }
        $ignoreTableCommand = implode(' ', $ignoreTables);

        // Step 3: 定义备份文件的保存路径
        $backupPath = storage_path("backups/{$database}_" . date('Y_m_d_His') . ".sql");
        $dir        = dirname($backupPath);
        if (!is_dir($dir)) {
            mkdir($dir, 777, true);
        }

        // Step 4: 使用 mysqldump 命令备份数据
        $this->info("Starting database backup...");
        $command = "mysqldump -u$username -p$password -h$host --no-create-info $ignoreTableCommand $database > $backupPath";

        // 执行命令
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Database backup was successful. Backup file created at: $backupPath");
        } else {
            $this->error("Database backup failed.");
        }

    }
}
