<?php

namespace App\Command;


use App\Command\Messages\TextList;
use App\Models\TelegramVideos;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use function Symfony\Component\String\b;

class TeacherVideosUploadsCommand extends Command
{
    protected $name = 'teacher-videos-uploads';

    public function handle()
    {
        if (User::getUser()->upload_video === null) {
            /** проверка если не видео то ошибка */
            if ($this->getUpdate()->getMessage()->video == null) {
                return $this->replyWithMessage([
                    'text' => 'Загружать только видео.',
                ]);
            }

            $getFileName = RemoveMessages::getApi()->getFile([
                'file_id' => $this->getUpdate()->getMessage()->video->get('file_id')
            ]);

            if (copy('https://api.telegram.org/file/bot' . \Config::get('values.bot_token') . '/' . $getFileName->get('file_path'), storage_path('video/file.mp4'))) {
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries' => '/usr/bin/ffmpeg',
                    'ffprobe.binaries' => '/usr/bin/ffprobe'
                ]);
                $video = $ffmpeg->open(storage_path('video/file.mp4'));

                if ((int)$video->getFormat()->get('duration') > 30) {
                    return $this->replyWithMessage([
                        'text' => 'Очень большое видео разрешено до 30 секунд.',
                    ]);
                } elseif ((int)$video->getFormat()->get('duration') < 5) {
                    return $this->replyWithMessage([
                        'text' => 'Очень короткое видео.',
                    ]);
                }
            }

            $video = TelegramVideos::create([
                'file_name' => $this->getUpdate()->getMessage()->video->get('file_id'),
                'file_size' => (int)$this->getUpdate()->getMessage()->video->get('file_size'),
                'file_path' => $getFileName->get('file_path'),
                'user_id' => User::getUser()->id,
                'subject' => User::getUser()->subject,
            ]);

            User::getUser()->upload_video = $video->id;
            User::getUser()->save();

            $this->replyWithChatAction(['action' => Actions::TYPING]);

            $this->replyWithVideo([
                'caption' => sprintf('Видео которое Вы загрузили %s %s', "\n\n", $this->getUpdate()->getMessage()->caption),
                'video' => $this->getUpdate()->getMessage()->video->get('file_id'),
            ]);

            sleep(1);
        }
        return $this->saveData();
    }

    private function saveData()
    {
        $video = TelegramVideos::where('id', User::getUser()->upload_video)->first();

        $text = $this->getUpdate()->getMessage()->text;

        foreach (['theme', 'tags'] as $item) {
            switch ($item) {

                case 'theme':
                    if (is_null($video->theme)) {
                        if (mb_strlen($text) >= 5 and mb_strlen($text) <= 30) {
                            $video->theme = $text;
                            $video->save();

                            return $this->replyWithMessage([
                                'text' => 'Введите теги.',
                            ]);
                        }
                        return $this->replyWithMessage([
                            'text' => 'Введите название темы.',
                        ]);
                    }
                    break;

                case 'tags':

                    if (is_null($video->tags)) {
                        if (mb_strlen($text) >= 5 and mb_strlen($text) <= 200) {

                            /** save text */
                            $video->tags = TextList::getTags($text);
                            $video->save();

                            /** null upload_video */
                            User::getUser()->upload_video = null;
                            User::getUser()->command = 'teacher';
                            User::getUser()->save();

                            $this->replyWithMessage([
                                'text' => 'Видео добавлено.',
                            ]);

                            usleep(700);

                            return $this->triggerCommand('teacher');
                        }
                        return $this->replyWithMessage([
                            'text' => 'Очень мало тегов.',
                        ]);
                    }
                    break;
            }
        }
    }
}
