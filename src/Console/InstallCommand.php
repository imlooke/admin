<?php

namespace Imlooke\Admin\Console;

use Illuminate\Console\Command;
use Imlooke\Admin\DatabaseInstaller;

/**
 * InstallCommand
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the admin package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->installDatabase();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function installDatabase()
    {
        $this->call('migrate');

        (new DatabaseInstaller)->run();
    }
}
