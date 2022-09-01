<?php

namespace App\Http\Controllers;

use App\Models\TelegramRole;
use App\Models\TelegramUsers;
use App\Models\TelegramVideos;
use getID3;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class BotUsersController extends Controller
{

    public function __construct(
        Api $api
    )
    {
        $this->api = $api;





        $this->middleware('auth');
    }


    public function roles()
    {

        $users = TelegramRole::orderBy('id', 'DESC')->get();;

        return view('telegram.roles', [
                'users' => $users
            ]
        );
    }

    public function users()
    {
        return view('telegram.users', [
                'users' => TelegramUsers::all()
            ]
        );
    }

    public function filter(Request $request)
    {
        $request->validate([
            'student' => 'integer|min:0|max:1',
            'teacher' => 'integer|min:0|max:1',
            'status' => 'integer|min:0|max:1',
        ]);

        $users = TelegramUsers::all();

        if ($request->get('status') == 1) {
            $users = TelegramUsers::where('status', 3);
        }
        if ($request->get('teacher') == 1) {
            $users = TelegramUsers::where('role', 2);
        }
        if ($request->get('student') == 1) {
            $users = TelegramUsers::where('role', 1);
        }

        return response()->json(
            [
                'status' => 1,
                'result' => [
                    'filter' => view('telegram.users.item', [
                        'users' => $users->orderBy('id', 'DESC')->get()
                    ])->render()
                ]
            ]);
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'int',
            'status' => 'int',
        ]);

        if (in_array($request->get('status'), [3, 1])) {

            if ($users = TelegramUsers::find($request->get('id'))->get()) {
                TelegramUsers::where('id', $request->get('id'))->update(['status' => $request->get('status')]);

                return response()->json([
                    'status' => 1,
                    'result' => [
                        'messages' => 'Статус изменен',
                        'text' => ($request->get('status') == 1) ? ' Активный' : ' Заблокирован'
                    ]
                ]);
            }
        }
        return response()->json([
            'status' => 0,
            'error' => [
                'messages' => 'Ошибка видео не найдено.'
            ]
        ]);
    }

}
