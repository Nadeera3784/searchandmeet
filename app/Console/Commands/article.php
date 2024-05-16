<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use File;
use Illuminate\Support\Facades\Storage;

class article extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:article {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new .md Article by passing article name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folder = resource_path('views\\articles\\'.date('Y-m'));
        if (!File::exists($folder)) {
            try {
                File::makeDirectory($folder, 0775, true, true);
                $this->info('New Folder Created : '.$folder);
            } catch(\Exception $exception)
            {
                $this->error($exception->getMessage());
                return Command::FAILURE;
            }
        }
        $file = $folder.'\\'.$this->clean($this->argument('name')).".md";
        if (!File::exists($file)) {
            try {
                $fe = fopen($file, 'w',);
                fwrite($fe,'Sample .md data');
                fclose($fe);
                $this->info('New .md File Created : '.$file);
                $jsonFile = "[\n\t'title' => '{$this->argument('name')}',\n\t'image_url' => '',\n\t'description' => '',\n\t'date' => '".date('Y-m-d')."',\n\t'path' => '".date('Y-m').'/'.$this->clean($this->argument('name'))."'\n]";

                $this->info('Add below array to Article model in '.app_path('models\Article.php'));
                $this->info($jsonFile);
            } catch(\Exception $exception)
            {
                $this->error($exception->getMessage());
                return Command::FAILURE;
            }
        }else{
            $this->error('<error> File already exists </error>');
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
