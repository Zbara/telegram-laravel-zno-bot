<?php

namespace App\Http\Controllers;

use App\Models\TelegramUsers;
use App\Models\TelegramVideos;
use App\Telegram\User;
use App\Telegram\Webhook;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Chat;

class TelegramBotController extends Controller
{
    public function webHook(Webhook $webhook)
    {
         return $webhook->kernel();
    }
}
