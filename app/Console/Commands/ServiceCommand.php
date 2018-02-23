<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class ServiceCommand extends Command
{
    use DetectsApplicationNamespace;

    private $dirName;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to make service for repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dirName = "Services";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $namespace = $this->getAppNamespace() . $this->dirName;
        $name = $this->argument('name');
        $name .='Service';
        $fileContents = <<<EOD
<?php
namespace $namespace;

use Illuminate\Support\Facades\Auth;

class $name
{
    public function __construct()
    {

    }

    public function getAll()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}

EOD;
        $this->makeDirectory();
        $written = \File::put("app/{$this->dirName}/{$this->argument('name')}Service.php", $fileContents);
        if ($written) {
            $this->info("Created new Service {$this->argument('name')}Service.php in app/{$this->dirName}.");
        } else {
            $this->error('Something went wrong');
        }
    }

    public function checkDirectory()
    {
        return \File::exists("app/{$this->dirName}");
    }

    public function makeDirectory()
    {
        if (!$this->checkDirectory()) {
            \File::makeDirectory("app/{$this->dirName}", 0775, true);
        }
    }
}
