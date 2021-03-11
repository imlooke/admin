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
    protected $signature = 'admin:install {--directory= : Admin directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the admin package';

    /**
     * The Admin directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // must call publish first.
        $this->call('vendor:publish', [
            '--provider' => 'Imlooke\Admin\AdminServiceProvider'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Laravel\Sanctum\SanctumServiceProvider'
        ]);

        $this->installDatabase();

        $this->createAdminDirectory();
        $this->createRoutesFile();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    protected function installDatabase()
    {
        $this->call('migrate');

        (new DatabaseInstaller)->run();
    }

    /**
     * Create admin directory.
     *
     * @return void
     */
    protected function createAdminDirectory()
    {
        $this->directory = config('admin.directory', app_path('Admin'));

        if ($this->option('directory')) {
            $this->directory = app_path($this->option('directory'));
        }

        if (is_dir($this->directory)) {
            $this->error("{$this->directory} directory already exists!");
            return;
        }

        $this->makeDir('/');
    }

    /**
     * Create routes file.
     *
     * @return void
     */
    protected function createRoutesFile()
    {
        $file = $this->directory . DIRECTORY_SEPARATOR . 'routes.php';

        $this->laravel['files']->put(
            $file,
            $this->laravel['files']->get($this->getStub('routes')),
        );

        $this->line('<info>Routes file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Get the stub file for the generator.
     *
     * @param  string $name
     * @return string
     */
    protected function getStub($name)
    {
        return __DIR__ . "/stubs/$name.stub";
    }

    /**
     * Create directory.
     *
     * @param  string $path
     * @return void
     */
    protected function makeDir($path)
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }
}
