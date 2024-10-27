<?php

declare (strict_types=1);

namespace App\Service;

class SlugGenerator
{
    public function __invoke(string $stringToSlugify): string
    {
        $slug = mb_strtolower($stringToSlugify, 'UTF-8');

        $slug = trim($slug);
        $slug = $this->replaceSpecialCharacters($slug);
        $slug = preg_replace('![^'.preg_quote('-').'a-z0-9]+!u', '-', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('![-]{2,}!', '-', $slug);

        return $slug;
    }

    private function replaceSpecialCharacters(string $text): string
    {
        $charactersMap = [
            // Caractères latins
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae',
            'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ñ' => 'n',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'š' => 's', 'ž' => 'z',
            'ß' => 'ss',

            // Caractères cyrilliques (basique)
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g',
            'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',

            // Symboles courants
            '&' => 'and', '@' => 'at', '©' => 'c', '®' => 'r', '℗' => 'p',

            // Espaces spéciaux et ponctuations
            ' ' => '-', '_' => '-', '.' => '-', ',' => '-',
            ';' => '-', ':' => '-', '/' => '-', '\\' => '-',

            // Guillemets
            '\'' => '', '`' => '', '"' => '', '"' => '', '„' => '',

            // Autres caractères spéciaux
            '!' => '', '?' => '', '#' => '', '%' => '',
            '+' => '', '*' => '', '=' => '', '$' => '',
            '£' => '', '€' => '', '¥' => '', '§' => '',
            '°' => '', '^' => '', '~' => '', '|' => '',
            '(' => '', ')' => '', '[' => '', ']' => '',
            '{' => '', '}' => '', '<' => '', '>' => '',
        ];

        return strtr($text, $charactersMap);
    }

}
