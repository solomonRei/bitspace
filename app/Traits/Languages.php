<?php
namespace App\Traits;
use App\Models\Language;
use Illuminate\Support\Arr;

trait Languages {

    public function getLangId($key = false)
    {
        if (!$key) $key = in_array(app()->getLocale(), array_keys(config('app.languages'))) ? app()->getLocale() : 1;

        $language = Language::where('name', $key)->first();

        return $language->id;
    }

    public function getLangMainId()
    {
        $language = Language::where('main', 1)->first();
        return $language->id;
    }

    public function getLanguages()
    {
        if($language = Language::visible()->get()) return $language;

        return false;
    }

    public function insertData($data)
    {
        $array = [];
        if ($languages = $this->getLanguages()) {
            foreach ($data as $fields => $lang) {
                foreach ($languages as $language) {
                    if (Arr::has($lang, $language->name)) {
                        $array["{$language->name}"] = !isset($array["{$language->name}"]) ? [
                            "{$fields}" => $lang["{$language->name}"]
                        ] : array_merge($array["{$language->name}"], [
                            "{$fields}" => $lang["{$language->name}"]
                        ]);
                    }
                }
            }
        }
        return $array;
    }

}
