<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:update {--mail : Update only mail settings}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update .env file with required settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');
        
        // Check if .env file exists
        if (!File::exists($envPath)) {
            // If .env doesn't exist but .env.example does, copy it
            if (File::exists($envExamplePath)) {
                File::copy($envExamplePath, $envPath);
                $this->info('.env file created from .env.example');
            } else {
                // Create a new .env file
                File::put($envPath, '');
                $this->info('Created a new empty .env file');
            }
        }
        
        // Read current .env content
        $envContent = File::get($envPath);
        
        if ($this->option('mail')) {
            // Update only mail settings
            $this->updateMailSettings($envContent);
        } else {
            // Update all settings
            $this->updateAllSettings($envContent);
        }
    }
    
    /**
     * Update mail settings in .env file.
     *
     * @param string $envContent
     * @return void
     */
    protected function updateMailSettings($envContent)
    {
        $mailSettings = [
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => 'one2one4.com',
            'MAIL_PORT' => '465',
            'MAIL_USERNAME' => 'info@one2one4.com',
            'MAIL_PASSWORD' => 'dZw94pryhu7wY2c',
            'MAIL_ENCRYPTION' => 'ssl',
            'MAIL_FROM_ADDRESS' => 'info@one2one4.com',
            'MAIL_FROM_NAME' => 'One2One4',
        ];
        
        $updatedContent = $this->updateEnvVariables($envContent, $mailSettings);
        
        // Save the updated content
        File::put(base_path('.env'), $updatedContent);
        
        $this->info('Mail settings updated in .env file');
    }
    
    /**
     * Update all settings in .env file.
     *
     * @param string $envContent
     * @return void
     */
    protected function updateAllSettings($envContent)
    {
        // Add more settings here if needed
        $this->updateMailSettings($envContent);
    }
    
    /**
     * Update environment variables in .env file.
     *
     * @param string $envContent
     * @param array $variables
     * @return string
     */
    protected function updateEnvVariables($envContent, $variables)
    {
        foreach ($variables as $key => $value) {
            // Check if the variable exists
            if (preg_match("/^{$key}=.*$/m", $envContent)) {
                // Replace existing variable
                $envContent = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $envContent);
            } else {
                // Add new variable
                $envContent .= PHP_EOL . "{$key}={$value}";
            }
        }
        
        return $envContent;
    }
}
