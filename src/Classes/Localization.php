<?php

namespace Mahmoudmhamed\LaravelHelpers\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

/**
 * used to get and set locale of the current session.
 * @author mahmoud-mhamed <mahmoud1272022@gmail.com>
 */
class Localization
{
    /**
     * will get the current language of the session
     * @return string $locale
     */
    public static function getLocale(): string
    {
        return App::getLocale();
    }

    /**
     * will set the current language of the session
     * @param string $language
     * @return bool
     */
    public static function setLocale(string $language): bool
    {
        $locals = config('helpers.localization.local', ['ar', 'en']);
        $language = in_array($language, $locals) ? $language : config('helpers.localization.default', 'ar');
        return App::setLocale($language) ?? true;
    }

    /**
     * @param string|null $locale
     * @return JsonResponse|void
     */
    public static function setLocaleHeader(string $locale = null)
    {
        if (!$locale) {
            $locale = request()->header(config('helpers.localization.api-header-key', 'Content-Language'));
            if (!$locale)
                return response()->json(['message' => trans('helpers::LaravelHelper.setHeaderLang')], 200);
        }

        self::setlocale($locale);
    }

    public static function getHtmlDirection(): string
    {
        return App::getLocale() === 'ar' ? 'rtl' : 'ltr';
    }


    public static function getTranslation($value, $local = null)
    {
        if (is_array($value)) {
            $local = $local ?? self::getLocale();
            if ($local != '*')
                return $value[$local] ?? $value[config('helpers.localization.default', 'ar')] ?? $value;
        }
        return $value;
    }
}
