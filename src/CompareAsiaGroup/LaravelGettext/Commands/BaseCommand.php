<?php namespace CompareAsiaGroup\LaravelGettext\Commands;

use Illuminate\Console\Command;
use Xinax\LaravelGettext\FileSystem;
use Xinax\LaravelGettext\Config\ConfigManager;

class BaseCommand extends Command
{

    /**
     * Filesystem helper
     * @var \CompareAsiaGroup\LaravelGettext\FileSystem
     */
    protected $fileSystem;

    /**
     * Package configuration data
     * @var Array
     */
    protected $configuration;    

    /**
     * Prepares the package environment for gettext commands
     * 
     * @return void 
     */
    protected function prepare()
    {
        $configManager = ConfigManager::create();
        
        $this->fileSystem = new FileSystem($configManager->get(),
            app_path(),
            storage_path()
        );

        $this->configuration = $configManager->get();
    }

}
