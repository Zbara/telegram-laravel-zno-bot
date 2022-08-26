<?php

namespace App\Http\Controllers;

use App\Models\TelegramRole;
use App\Models\TelegramUsers;
use App\Telegram\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;

class ApiController extends Controller
{
    private Api $api;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Api $api
    )
    {
        $this->api = $api;

        $this->middleware('auth');
    }


    public function removeRole(Request $request)
    {
        $request->validate([
            'id' => 'int',
        ]);

        if ($role = TelegramRole::find($request->get('id'))) {
            $role->delete();

            return response()->json([
                'status' => 1,
                'result' => [
                    'messages' => 'Успешно удалено',
                ]
            ]);
        }
        return response()->json([
            'status' => 0,
            'error' => [
                'messages' => 'Ошибка'
            ]
        ]);
    }

    public function editRole(Request $request)
    {
        $request->validate([
            'id' => 'int',
            'status' => 'int',
        ]);

        if (in_array($request->get('status'), [0, 1])) {
            $roleNew = TelegramRole::where('id', $request->get('id'))->where('status', 0)->get();

            if ($roleNew->value('id') !== null) {

                $user = TelegramUsers::find($roleNew->value('user_id'));

                if ($request->get('status') == 1) {
                    $user->role = $roleNew->value('role');
                    $user->command = 'start';
                    $user->save();
                }
                TelegramRole::where('id', $request->get('id'))->update(['status' => 1]);

                try {
                    if ($request->get('status') == 1) {
                        $this->api->sendMessage([
                            'text' => 'Вам сменили роль, нажмите /start',
                            'chat_id' => $user->platform_id,
                        ]);
                    } else {
                        $this->api->sendMessage([
                            'text' => 'Вам отказали у смене роли.',
                            'chat_id' => $user->platform_id,
                        ]);
                    }
                } catch (TelegramSDKException $e) {
                    \Debugbar::info($e->getMessage());
                }

                return response()->json([
                    'status' => 1,
                    'result' => [
                        'messages' => 'Роль изменена',
                        'text' => '  Просмотренная'
                    ]
                ]);
            }
            return response()->json([
                'status' => 0,
                'error' => [
                    'messages' => 'Заявки уже обработана'
                ]
            ]);
        }
        return response()->json([
            'status' => 0,
            'error' => [
                'messages' => 'Ошибка'
            ]
        ]);
    }
}
