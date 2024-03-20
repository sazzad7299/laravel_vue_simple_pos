<?php

namespace App\Services;

use Dotenv\Dotenv;
use App\Models\Settings;
use App\Traits\ImageUpload;

class SettingsService
{
    use ImageUpload;
    public function smtp()
    {

        return [
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
        ];
    }
    public function smsinfo()
    {

        return [
            'RELEANS_API_KEY' => env('RELEANS_API_KEY'),
            'RELEANS_API_FROM' => env('RELEANS_API_FROM'),
            'TWOFACTORS_API_KEY' => env('TWOFACTORS_API_KEY'),
            'MSG91_TEMPLATE_ID' => env('MSG91_TEMPLATE_ID'),
            'MSG91_AUTH_KEY' => env('MSG91_AUTH_KEY'),
            'TWILIO_SID' => env('TWILIO_SID'),
            'TWILIO_SERVICE_SID' => env('TWILIO_SERVICE_SID'),
            'TWILIO_TOKEN' => env('TWILIO_TOKEN'),
            'TWILIO_FROM' => env('TWILIO_FROM'),
            'SMS_METHOD' => env('SMS_METHOD'),
        ];

    }

    public function updateSettings($request){
        foreach ($request->validated() as $key => $value) {
            if (($key === 'logo' || $key === 'icon') && empty($value)) {
                continue; // Skip the update for 'logo' or 'icon' if the value is empty
            }

            if (($key === 'logo' || $key === 'icon') && !empty($value)) {
                $uploadedPath = $this->base64FileStore($value, 'images/company/', rand(10000, 99999));
                $value = $uploadedPath;
            }

            // Update or create the setting
            Settings::updateOrCreate(['meta_key' => $key], ['meta_value' => $value]);
        }

    }
    public function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            throw new \Exception('.env file not found.');
        }
        $contents = file_get_contents($envPath);
            foreach ($data as $key => $value) {
                $value = addslashes($value);
                if (preg_match('/\s|[^A-Za-z0-9_\-\.]/', $value)) {
                    $value = '"' . $value . '"';
                }
                $pattern = "/^{$key}=(.*)/m";
                $replacement = "{$key}={$value}";

                if (preg_match($pattern, $contents)) {
                    $contents = preg_replace($pattern, $replacement, $contents);
                } else {
                    $contents .= "\n{$replacement}";
                }
            }
        file_put_contents($envPath, $contents);
    }
    public function getCompanySettings()
    {
        $settings = [
            'company_name',
            'company_contanct_no',
            'company_address',
            'company_email',
            'logo',
            'icon',
            'currency_symbol',
            'currency_code',
        ];

        $companySettings = [];

        foreach ($settings as $key) {
            $value = Settings::where('meta_key', $key)->value('meta_value');
            $companySettings[$key] = $value;
        }

        return $companySettings;
    }
}
