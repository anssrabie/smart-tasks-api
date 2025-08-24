<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
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
        $modelVar = lcfirst($modelName);
        $className = ucfirst($modelName) . 'Repository';
        $namespace = 'App\\Repositories' . (count($segments) ? '\\' . implode('\\', $segments) : '');

        $directory = app_path('Repositories/' . implode('/', $segments));
        $filePath = $directory . '/' . $className . '.php';

        if (File::exists($filePath)) {
            $this->error("Repository $className already exists in {$namespace}!");
            return;
        }

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }


        $content = <<<EOT
<?php

namespace $namespace;

use App\\Repositories\\BaseRepository;
use App\\Models\\$modelName;

class $className extends BaseRepository
{
    public function __construct(protected $modelName \$${modelVar})
    {
        parent::__construct(\$${modelVar});
    }
}
EOT;


        File::put($filePath, $content);

        $this->info("Repository $className created successfully in {$namespace}!");
    }
}
