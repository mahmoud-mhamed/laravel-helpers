<?php

namespace App\Console\Commands;

use Datlechin\GoogleTranslate\Facades\GoogleTranslate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class TransLangFilesCommand extends Command
{
    /*
     * composer require datlechin/laravel-google-translate
     * */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trans lang folder form lang to other languages';

    protected array $ignored_file_from_trans = [
        'abilities.php', 'pagination.php', 'passwords.php'
    ];

    protected array $trans_only_file = [
        'validation.php'
    ];

    protected array $target_lang = [
        'en'
    ];

    protected string $source_lang = "ar";
    protected bool $translate_by_google_translate = true;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->progressStart(count($this->target_lang));
        $all_files = File::allFiles(lang_path($this->source_lang));
        $this->removeIgnoredFileFromTrans($all_files, $this->ignored_file_from_trans);
        $this->transOnlyFile($all_files, $this->trans_only_file);

        $this->output->progressStart(count($all_files));

        foreach ($all_files as $file) {
            $file_name_with_ex = $file->getBasename();
            App::setLocale($this->source_lang);
            $translation_source = trans($file->getBasename('.php'), array(), null, $this->source_lang);
            foreach ($this->target_lang as $el_new_lang) {
                App::setLocale($el_new_lang);
                $translation_target = trans($file->getBasename('.php'), array(), null, $this->source_lang);
                $translation_target_updated = $this->tranArray($translation_target, $translation_source, $el_new_lang);
                $new_content = var_export($translation_target_updated, true);

                $new_content = preg_replace("/=> \n\s*array \(/", "=> [", $new_content);

                $new_content = str_replace('array (', '[', $new_content);
                $new_content = str_replace('),', '],', $new_content);
                $new_content .= ';';
                $new_content = str_replace(');', '];', $new_content);
                file_put_contents(lang_path($el_new_lang) . '/' . $file_name_with_ex,
                    "<?php\n\nreturn " . $new_content . "\n"
                );
            }
        }


        $this->output->progressFinish();
    }

    private function translate(string|null $current_trans, string $text_to_translate, string $target_lang): string
    {
        if ($current_trans && $current_trans !== $text_to_translate) {
            return $current_trans;
        }
        if (!$this->translate_by_google_translate)
            return $current_trans ?? $text_to_translate;
        $result = GoogleTranslate::source($this->source_lang)
            ->target($target_lang)
            ->translate($text_to_translate);

        return $result->getTranslatedText();
    }

    private function tranArray(array|null|string $current_words, array $words_array, $el_new_lang): array
    {
        $source_lang = $this->source_lang;
        $response = [];
        foreach ($words_array as $key => $value) {
            if (is_array($value)) {
                $value_translated = $this->tranArray(data_get($current_words, $key), $value, $el_new_lang);
                $response[$key] = $value_translated;
            } else {
                $exist_trans = data_get($current_words, $key);
                if (is_array($exist_trans))
                    $exist_trans = null;
                $response[$key] = $this->translate($exist_trans, $value, $el_new_lang);
            }
        }
        return $response;
    }

    private function removeIgnoredFileFromTrans(&$all_files, array $ignored_files = []): void
    {
        if (!count($ignored_files))
            return;
        $all_files = array_filter($all_files, function ($e) use ($ignored_files) {
            return !in_array($e->getBasename(), $ignored_files);
        });
    }

    private function transOnlyFile(&$all_files, array $only_file = []): void
    {
        if (!count($only_file))
            return;
        $all_files = array_filter($all_files, function ($e) use ($only_file) {
            return in_array($e->getBasename(), $only_file);
        });
    }
}
