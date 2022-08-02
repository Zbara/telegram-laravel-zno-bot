<?php

namespace App\Command\Messages;

use App\Telegram\User;

class Subject
{
    public static function items(int $id)
    {
        if (array_key_exists($id, TextList::$items)) {
            User::getUser()->subject = $id;
            User::getUser()->save();
        }
        return (isset(TextList::$items[User::getUser()->subject])) ? TextList::$items[User::getUser()->subject] : 'Не известно.';
    }
}
