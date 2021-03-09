<?php

namespace Imlooke\Admin\Console;

use Illuminate\Console\Command;
use Imlooke\Admin\DatabaseInstaller;

/**
 * UninstallCommand
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UninstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the admin package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure to uninstall Imlooke-admin?')) {
            return;
        }

        $this->line('Uninstalling Imlooke-admin...');

        $this->removeFilesAndDirectories();

        $this->info('Uninstall laravel-admin succeeded!');
    }

    /**
     * Remove files and directories.
     *
     * @return void
     */
    protected function removeFilesAndDirectories()
    {
        $this->laravel['files']->deleteDirectory(config('admin.directory'));
        $this->laravel['files']->delete(config_path('admin.php'));
    }
}
