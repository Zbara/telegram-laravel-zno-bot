<?php

namespace App\Command\Messages;

class TextList
{
    public static array $items = [
        0 => 'Тестовый',
        1 => 'Обществознание',
        2 => 'Алгебра',
        3 => 'Геометрия',
    ];


    public static function getTags(string $text): ?string
    {
        $text = explode(' ', str_replace('  ', ' ', $text));

        $str = null;
        foreach ($text as $item) {
            $string = str_replace('-', '_', $item);
            $string = str_replace(',', '_', $string);
            $string = str_replace('.', '_', $string);
            $string = str_replace('!', '_', $string);
            $string = str_replace('#', '', $string);
            $string = str_replace(' ', '', $string);

            $str .= sprintf('#%s ', mb_strtolower($string));
        }

        return $str;
    }
}
