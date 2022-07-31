<?php

namespace App\Command\Messages;

use App\Telegram\User;

class Subject
{
    public static function items(string $text)
    {
        if (array_search($text, TextList::$items) !== null) {
            User::getUser()->subject = array_search($text, TextList::$items);
            User::getUser()->save();
        }
        return (isset(TextList::$items[User::getUser()->subject])) ? TextList::$items[User::getUser()->subject] : 'Не известно.';
    }
}
