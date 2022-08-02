<?php

namespace App\Telegram;

class Callback
{
    private static array $params = [];

    public static function setParams(string $params): array|bool
    {
        $data = explode(',', $params);

        if (isset($data[0])) {
            self::$params = $data;

            return true;
        }
        return false;
    }

    public static function getParams(int $key = 0)
    {
        if(isset($key)) {
            return self::$params[$key];
        }
        return self::$params;
    }
}
