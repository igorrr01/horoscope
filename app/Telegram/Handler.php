<?

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Http\Request;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Support\Stringable;
use DefStudio\Telegraph\Facades\Telegraph;
use Illuminate\Support\Facades\Storage;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use App\Http\Controllers\Helper;

class Handler extends WebhookHandler
{

    // Обрабатываем команды
    public function hello()
    {
        $this->reply('Привет! Это первое сообщение :)');
        /*         $users = DB::table('telegraph_chats')->get();
        foreach($users as $user){
            $messageToAllUsers = TelegraphChat::find($user->id);
            $messageToAllUsers->message('провера массовой рассылки всем пользователям бота')->send();
        } */
    }

    // Обрабатываем неизвестные команды
    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() === '/start') {
            $this->chat->message('
*Привет! Я - гороскоп бот ✨*

Я предскажу твой день на завтра, проверю вашу совместимость с партнером, а также сделаю расклад на картах Таро 🔮
            ')->photo(Storage::path('start_logo.jpeg'))->send();

            $this->chat->message('1')->replyKeyboard(Helper::replyKeybordMainPage())->send();
        } else {
            $this->reply('Неизвестная команда');
        }
    }

    // Обрабатываем входящие сообщения
    protected function handleChatMessage(Stringable $text): void
    {
        if ($text == '🏠 Главное меню') {
            $this->chat->message('🏠 Главное меню')->replyKeyboard(Helper::replyKeybordMainPage())->send();
        }

        if ($text == '🪬 Хиромантия') {
            Helper::hiromant($this->chat);
        }

        if ($text == '🔮 Гороскоп' || $text == '💟 Любовный гороскоп') {

            if ($text == '🔮 Гороскоп'){
                $textMessage = '*🔮 Выберите Ваш знак зодиака, чтобы узнать гороскоп на сегодня*';
                $messageIMG = 'horoscope.jpg';
            }
            if ($text == '💟 Любовный гороскоп'){
                $textMessage = '*💟 Выберите Ваш знак зодиака, чтобы узнать 💞 любовный гороскоп на сегодня*';
                $messageIMG = 'love_horocope2.jpg';
            }

            $this->chat->message("$textMessage")->photo(Storage::path("$messageIMG"))
                ->replyKeyboard(Helper::replyKeybordZodiac())->send();

            if ($text == '🔮 Гороскоп') {
                $horoscope_type = 'general';
            }
            if ($text == '💟 Любовный гороскоп') {
                $horoscope_type = 'love';
            }
            // Обновляем тип гороскопа в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update([
                    'horoscope_type' => $horoscope_type
                ]);
        }

        if($text == '♈️ Овен' || $text == '♉️ Телец' || $text == '♊️ Близнецы' || $text == '♋️ Рак'
            || $text == '♌️ Лев' || $text == '♍️ Дева' || $text == '♎️ Весы' || $text == '♏️ Скорпион'
            || $text == '♐️ Стрелец' || $text == '♑️ Козерог' || $text == '♒️ Водолей' || $text == '♓️ Рыбы'){

            // Получаем названия зодиака на англ.
            $zodiac = Helper::zodiacName($text);

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$zodiac}/today.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $dt = Carbon::now();
            $todayDate = str_replace('-', '.', $dt->format('d.m.Y'));

            $this->chat->message("*$text* на $todayDate

🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update(['last_zodiac' => $zodiac]);
        }

        // Гороскоп на завтра
        if ($text == 'На завтра') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/tomorrow.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на неделю
        if ($text == 'На неделю') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/week.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на месяц
        if ($text == 'На месяц') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/month.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на год
        if ($text == 'На год') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/year.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
                ->where('chat_id', $this->chat->chat_id)
                ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Обновляем дату последнего запроса к боту
        DB::table('telegraph_chats')
        ->where('chat_id', $this->chat->chat_id)
        ->update(['updated_at' => Carbon::now()]);
    }
}
