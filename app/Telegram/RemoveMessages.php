<?php

namespace App\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class RemoveMessages
{
    public static function remove(): void
    {
        $api = new Api();

        if ($callback = $api->getWebhookUpdate()->get('callback_query')) {
            try {
                $api->deleteMessage(['message_id' => $callback->getMessage()->get('message_id'), 'chat_id' => $callback->getMessage()->chat->get('id')]);
            } catch (TelegramSDKException $e) {
                \Log::error($e->getMessage());
            }
        }
    }
}
