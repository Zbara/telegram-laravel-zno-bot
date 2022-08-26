<?php

namespace App\Http\Controllers;

use App\Models\TelegramRole;
use App\Models\TelegramUsers;
use App\Models\TelegramVideos;
use App\Telegram\User;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Telegram\Bot\Api;

class VideosController extends Controller
{

    private Api $api;

    public function __construct(
        Api $api
    )
    {
        $this->api = $api;

        $this->middleware('auth');
    }


    public function getVideo(int $id)
    {
        $video = TelegramVideos::find($id)->get();

        if ($video) {
            $response = Response::make(file_get_contents('https://api.telegram.org/file/bot' . env('TELEGRAM_BOT_TOKEN') . '/' . $video->value('file_path')));
            $response->header('Content-Type', "video/mp4");


            return $response;
        }
        throw new NotFoundHttpException();
    }


    public function videos()
    {
        return view('telegram.videos', [
                'videos' => TelegramVideos::orderBy('id', 'DESC')->get()
            ]
        );
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'int',
        ]);

        if ($videos = TelegramVideos::find($request->get('id'))) {
            $videos->subscribers()->delete();
            $videos->fave()->delete();
            $videos->delete();

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


    public function status(Request $request)
    {
        $request->validate([
            'id' => 'int',
            'status' => 'int',
        ]);

        if (in_array($request->get('status'), [0, 1])) {

            if ($video = TelegramVideos::find($request->get('id'))->get()) {
                TelegramVideos::where('id', $request->get('id'))->update(['status' => $request->get('status')]);

                return response()->json([
                    'status' => 1,
                    'result' => [
                        'messages' => 'Статус изменен',
                        'text' => ($request->get('status') == 1) ? ' Включено' : ' Выключено'
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
