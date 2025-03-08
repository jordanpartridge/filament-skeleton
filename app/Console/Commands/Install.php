<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\text;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application with a short wizard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->task("Set up application configuration", function () {

           // Query
           $application_name = text('What is the name of your application?');

           // Set
           Env::set('APP_NAME', $application_name);  

           // Verify    
           return env('APP_NAME') === $application_name;
        });
    }

   
}
