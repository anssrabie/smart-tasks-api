<?php

namespace App\Console\Commands;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInterfaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = str_replace('\\', '/', $name);
        $segments = explode('/', $path);
        $modelName = array_pop($segments);
        $interfaceName = ucfirst($modelName) . 'RepositoryInterface';
        $namespace = 'App\\Repositories\\Contracts' . (count($segments) ? '\\' . implode('\\', $segments) : '');

        $directory = app_path('Repositories/Contracts/' . implode('/', $segments));
        $filePath = $directory . '/' . $interfaceName . '.php';

        if (File::exists($filePath)) {
            $this->error("Interface $interfaceName already exists in {$namespace}!");
            return;
        }

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }


        $content = <<<EOT
<?php

use App\\Repositories\\Contracts\\BaseRepositoryInterface;
namespace $namespace;

interface  $interfaceName  extends BaseRepositoryInterface
{

}
EOT;


        File::put($filePath, $content);

        $this->info("Interface $interfaceName created successfully in {$namespace}!");
    }
}
