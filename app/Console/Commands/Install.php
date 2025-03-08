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
     * @var string
     */
    protected $description = 'Setup the application with a short wizard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->task("Set up application configuration", function () {
            $application_name = text('What is the name of your application?');
            
            $this->setEnv('APP_NAME', $application_name);
            
            return true;
        });
    }

    /**
     * Set an environment variable in the .env file
     * 
     * @param string $key
     * @param string $value
     * @return void
     */
    private function setEnv($key, $value)
    {
        $path = base_path('.env');
        $env = file_get_contents($path);
        
        // Properly escape the key for regex
        $escapedKey = preg_quote($key, '/');
        
        // Use word boundaries or line start/equals to ensure exact key match
        $pattern = "/^{$escapedKey}=(.*)/m";
        
        // If the key exists, replace it
        if (preg_match($pattern, $env)) {
            $env = preg_replace($pattern, "{$key}={$value}", $env);
        } else {
            // If the key doesn't exist, add it
            $env .= "\n{$key}={$value}";
        }
        
        file_put_contents($path, $env);
        
        // Clear config cache to apply changes
        $this->callSilently('config:clear');
    }
}