<?php

namespace App\Command;


use App\Models\TelegramVideos;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Carbon\Carbon;
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
            $video = TelegramVideos::create([
                'file_name' => $this->getUpdate()->getMessage()->video->get('file_id'),
                'file_size' => (int)$this->getUpdate()->getMessage()->video->get('file_size'),
                'user_id' => User::getUser()->id,
                'subject' => User::getUser()->subject,
                'tags' => $this->getUpdate()->getMessage()->caption,
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
                                'text' => 'Введите теги в таком формате, #test, #zbara.',
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
                            $video->tags = $text;
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
