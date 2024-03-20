<?php

namespace App\Services;

use Exception;
use App\Models\Cost;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LanguageService
{
    public function get()
    {
        $language = Settings::where('meta_key', 'language')
            ->select('meta_value')
            ->first();
        if ($language) {
            return json_decode($language->meta_value);
        }
        return null;
    }

    public function store($request)
    {
        $data = [];
        $this->createFile($request->code);
        $language = Settings::where('meta_key', 'language')->first();
        if ($language) {
            $data = json_decode($language['meta_value'], true);
        }
        if (array_search($request['code'], array_column($data, 'code')) !== false) {
            throw new Exception('Language already added');
        }
        $newItem = [
            'id' => count($data) + 1,
            'name' => $request['name'],
            'direction' => 'ltr',
            'code' => $request['code'],
            'status' => 1,
            'default' => false,
        ];

        $data[] = $newItem;
        $lang_array = json_encode($data, JSON_PRETTY_PRINT);

        Settings::updateOrInsert(['meta_key' => 'language'], [
            'meta_value' => $lang_array,
        ]);

        $languageCodes = array_column($data, 'code');
        Settings::updateOrInsert(['meta_key' => 'pnc_language'], [
            'meta_value' => json_encode($languageCodes),
        ]);
    }

    private function createFile($code)
    {
        $sourceLanguage = 'en';
        $langDirectory = base_path('lang/'.$code);
        if (! file_exists($langDirectory)) {
            mkdir($langDirectory, 0777, true);
        }

        $langFilePath = $langDirectory.'/'.'trans.php';
        if (! file_exists($langFilePath)) {
            copy(base_path('lang/'.$sourceLanguage.'/trans.php'), $langFilePath);
        }
    }

    public function update($request)
    {
        $data = [];
        $inputData = $request->validated();
        $language = Settings::where('meta_key', 'language')->first();
        if ($language) {
            $data = json_decode($language['meta_language'], true);
        }

        foreach ($data as &$item) {
            if ($item['code'] == $inputData['code']) {
                $item['name'] = $inputData['name'];
                $item['direction'] = $inputData['direction'] ?? 'ltr';
                break;
            }
        }
        $lang_array = json_encode($data, JSON_PRETTY_PRINT);

        Settings::where('meta_key', 'language')->update([
            'meta_value' => $lang_array,
        ]);
    }

    private function deleteFile($code)
    {
        $langDirectory = base_path('lang/'.$code);
        $langFilePath = $langDirectory.'/'.'trans.php';
        if (file_exists($langFilePath)) {
            unlink($langFilePath);
        }
        if (is_dir($langDirectory)) {
            if (! rmdir($langDirectory)) {
                throw new Exception('Error deleting language directory');
            }
        }
    }

    public function delete($code)
    {
        $language = Settings::where('meta_key', 'language')->first();

        if (empty($language)) {
            throw new Exception('Language not exist!');
        }

        $data = json_decode($language->meta_value, true);
        $indexToDelete = array_search($code, array_column($data, 'code'));

        if ($indexToDelete !== false) {
            $this->deleteFile($code);
            array_splice($data, $indexToDelete, 1);
            $lang_array = json_encode($data, JSON_PRETTY_PRINT);
            $language->meta_value = $lang_array;
            $language->save();
        } else {
            throw new Exception('Language not exist!');
        }
    }

    public function allCodes()
    {
        $flags = File::files(base_path('public/flags'));
        $fileNames = [];
        foreach ($flags as $flag) {
            $fileNames[] = pathinfo($flag->getFilename(), PATHINFO_FILENAME);
        }

        return $fileNames;
    }

    public function updateStatus($request)
    {
        $code = $request->code;

        $language = Settings::where('meta_key', 'language')->first();

        if (! $language) {
            throw new Exception('Language not found!');
        }

        $data = json_decode($language->meta_value, true);
        foreach ($data as &$item) {
            if ($item['code'] === $code) {
                $item['status'] = $item['status'] == 1 ? 0 : 1;
                break;
            }
        }

        $updatedValue = json_encode($data, JSON_PRETTY_PRINT);

        DB::table('settings')
            ->where('meta_key', 'language')
            ->update(['meta_value' => $updatedValue]);
    }

    public function updateDefaultStatus($request)
    {
        $code = $request->code;
        $language = Settings::where('key', 'language')->first();
        if (! $language) {
            throw new Exception('Language not found!');
        }
        $data = json_decode($language->value, true);
        foreach ($data as &$item) {
            if ($item['code'] === $code) {
                $item['status'] = 1;
                $item['default'] = true;
            } else {
                $item['default'] = false;
            }
        }
        $lang_array = json_encode($data, JSON_PRETTY_PRINT);
        $language->value = $lang_array;
        $language->save();
    }

    public function getTranslateData($code)
    {
        $langFilePath = base_path('lang/'.$code.'/trans.php');

        if (! file_exists($langFilePath)) {
            throw new Exception('Translation file not found for code '.$code);
        }
        $full_data = include $langFilePath;
        ksort($full_data);

        return $full_data;
    }

    public function translateSubmit($request, $code)
    {
        
        $langFilePath = base_path('lang/'.$code.'/trans.php');
        $full_data = include $langFilePath;
        $translations = $request->input('translations');
        foreach ($translations as $key => $value) {
            if (isset($full_data[$key])) {
                $full_data[$this->remove_invalid_characters($key)] = $value;
            }
        }
        $str = '<?php return '.var_export($full_data, true).';';
        File::put($langFilePath, $str);
        $data = $this->getTranslateData($code);
        return  $data;
    }

    private function remove_invalid_characters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', preg_replace('/\s\s+/', ' ', $str));
    }

    public function translate_key_remove($request, $code)
    {
        Log::info($request['key']);
        $langFilePath = base_path('resources/lang/'.$code.'/messages.php');
        $full_data = include $langFilePath;
        unset($full_data[$request['key']]);
        $str = '<?php return '.var_export($full_data, true).';';
        file_put_contents($langFilePath, $str);
    }

    public function activeList()
    {
        $language = Settings::where('key', 'language')
            ->select('value')
            ->first();

        if ($language) {
            $data = json_decode($language->value, true);
            usort($data, function ($a, $b) {
                if ($a['default'] === true) {
                    return -1; // $a should come before $b
                } elseif ($b['default'] === true) {
                    return 1; // $b should come before $a
                } else {
                    return 0; // No change in order
                }
            });
            $activeData = array_filter($data, function ($item) {
                return $item['status'] == 1;
            });

            return $activeData;
        }

        return [];
    }

    public function translations($code)
    {
        $langFilePath = base_path('resources/lang/'.$code.'/messages.php');
        $full_data = include $langFilePath;

        return $full_data;
    }
}