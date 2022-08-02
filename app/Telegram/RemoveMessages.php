<?php

namespace App\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class RemoveMessages
{
    private static Api $api;

    public function __construct(
        Api $api
    ){
        static::$api = $api;
    }

    public static function remove(): void
    {

        if ($callback = static::$api->getWebhookUpdate()->get('callback_query')) {
            try {
                static::$api->deleteMessage(['message_id' => $callback->getMessage()->get('message_id'), 'chat_id' => $callback->getMessage()->chat->get('id')]);
            } catch (TelegramSDKException $e) {
                \Log::error($e->getMessage());
            }
        }
    }
}
