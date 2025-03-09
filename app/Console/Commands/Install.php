<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\info;
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
        $this->setApplicationName();

        if ($this->herdInstalled()) {
            $this->checkHerdSite();
        }

    }

    private function setApplicationName()
    {
        return $this->task('Set up application Name', function () {
            $application_name = text('What is the name of your application?');

            $this->setEnv('APP_NAME', $application_name);

            return true;
        });
    }

    private function herdInstalled(): bool
    {
        return $this->task('Check if Laravel Herd is installed', function () {
            return Process::run('herd --version')->successful();
        });
    }

    private function checkHerdSite()
    {
        $this->task('Check if the site is available', function () {
            $projectName = basename(base_path());
            $url = "http://{$projectName}.test";

            try {
                $response = \Illuminate\Support\Facades\Http::timeout(2)
                    ->connectTimeout(2)
                    ->head($url);

                if ($response->successful()) {
                    info("Site {$url} is accessible (HTTP {$response->status()})");

                    return true;
                } else {
                    info("Site {$url} returned HTTP {$response->status()}");

                    return false;
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                info("Cannot connect to {$url}: Connection refused");
                info('Please check if Laravel Herd is running');

                return false;
            } catch (\Exception $e) {
                info('Error checking site: '.$e->getMessage());

                return false;
            }
        });
    }

    /**
     * Set an environment variable in the .env file
     *
     * @param  string  $key
     * @param  string  $value
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
            $env = preg_replace($pattern, "{$key}=\"$value\"", $env);
        } else {
            // If the key doesn't exist, add it
            $env .= "\n{$key}={$value}";
        }

        file_put_contents($path, $env);

        // Clear config cache to apply changes
        $this->callSilently('config:clear');
    }
}
