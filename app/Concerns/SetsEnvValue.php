<?php

namespace App\Concerns;

trait SetsEnvValue
{
    /**
     * Set the value of an environment variable in the .env file.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setEnvValue(string $key, string $value): void
    {
        $envFile = base_path('.env');
        $content = file_get_contents($envFile);

        $pattern = "/^{$key}=.*/m";
-       $replacement = "{$key}={$value}";
+       $replacement = "{$key}=\"{$value}\"";

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
        } else {
-           $content .= PHP_EOL . "{$key}={$value}";
+           $content .= PHP_EOL . "{$key}=\"{$value}\"";
        }

        file_put_contents($envFile, $content);
    }
}
