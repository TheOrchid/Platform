<?php

namespace Orchid\Foundation\Filters\Transformer;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Created by PhpStorm.
 * User: joker
 * Date: 07.02.17
 * Time: 13:12.
 */
class PlaceListTransformer extends Transformer
{
    private $locales = [];

    /**
     * PlaceListTransformer constructor.
     */
    public function __construct()
    {
        $this->locales = config('content.locales');
    }

    public static function transform($collect)
    {
        $locale = App::getLocale();

        if ($locale == null) {
            $locale = 'en';
        }

        return $collect->map(function ($item) use ($locale) {
            return [
                'title' => $item['content'][$locale]['place']['name'],
                'lat'   => $item['content'][$locale]['place']['lat'],
                'lng'   => $item['content'][$locale]['place']['lng'],
            ];
        });
    }
}
