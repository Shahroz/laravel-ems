<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class RepositoryCommand extends Command
{
    use DetectsApplicationNamespace;

    private $dirName;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository for model commuication';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dirName = "Repositories";
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
        $name .= 'Repository';
        $fileContents = <<<EOD
<?php

namespace $namespace;

use DB;
use Auth;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class $name extends AbstractRepository
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
        $written = \File::put("app/repositories/{$this->argument('name')}Repository.php", $fileContents);
        if ($written) {
            $this->info("Created new Repository {$this->argument('name')} Repository.php in app/Repositories.");
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
