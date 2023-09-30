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
        if($text->value() === '/start'){
            $this->chat->message('
*Привет! Я - гороскоп бот ✨*

Я предскажу твой день на завтра, проверю вашу совместимость с партнером, а также сделаю расклад на картах Таро 🔮
            ')->photo(Storage::path('start_logo.jpeg'))->send(); 
            
            $this->chat->message('1')->replyKeyboard(ReplyKeyboard::make()
                ->row([
                ReplyButton::make('💟 Совместимость'),
                ReplyButton::make('🔮 Гороскоп'),    
                ])
                ->row([ 
                ReplyButton::make('🟣 Магия чисел'),
                ReplyButton::make('🀄️ Карты таро'),
                ])
                ->row([ 
                ReplyButton::make('🏵 Восточный гороскоп'),
                ])
            )
            ->send();

        }else{
            $this->reply('Неизвестная команда');
        }

    }


    // Обрабатываем входящие сообщения
    protected function handleChatMessage(Stringable $text): void
    {
        if($text == '🏠 Главное меню'){
                        $this->chat->message('1')->replyKeyboard(ReplyKeyboard::make()
                            ->row([
                            ReplyButton::make('💟 Совместимость'),
                            ReplyButton::make('🔮 Гороскоп'),    
                            ])
                            ->row([ 
                            ReplyButton::make('🟣 Магия чисел'),
                            ReplyButton::make('🀄️ Карты таро'),
                            ])
                            ->row([ 
                            ReplyButton::make('🏵 Восточный гороскоп'),
                            ])
                        )
                        ->send();
        }

        if($text == '🔮 Гороскоп'){

            // Добавляем новые кнопки
            $this->chat->message('2')->replyKeyboard(ReplyKeyboard::make()
                ->row([
                ReplyButton::make('♈️ Овен'),
                ReplyButton::make('♉️ Телец'),    
                ReplyButton::make('♊️ Близнецы'),    
                ])
                ->row([ 
                ReplyButton::make('♋️ Рак'),
                ReplyButton::make('♌️ Лев'),
                ReplyButton::make('♍️ Дева'),
                ])
                ->row([ 
                ReplyButton::make('♎️ Весы'),
                ReplyButton::make('♏️ Скорпион'),
                ReplyButton::make('♐️ Стрелец'),
                ])
                ->row([ 
                ReplyButton::make('♑️ Козерог'),
                ReplyButton::make('♒️ Водолей'),
                ReplyButton::make('♓️ Рыбы'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();
        }

        if($text == '♈️ Овен' || $text == '♉️ Телец' || $text == '♊️ Близнецы' || $text == '♋️ Рак' 
        || $text == '♌️ Лев' || $text == '♍️ Дева' || $text == '♎️ Весы' || $text == '♏️ Скорпион' 
        || $text == '♐️ Стрелец' || $text == '♑️ Козерог' || $text == '♒️ Водолей' || $text == '♓️ Рыбы'){

            if($text == '♈️ Овен'){
                $zodiac = 'aries';
            }
            if($text == '♉️ Телец'){
                $zodiac = 'taurus';
            }
            if($text == '♊️ Близнецы'){
                $zodiac = 'gemini';
            }
            if($text == '♋️ Рак'){
                $zodiac = 'cancer';
            }
            if($text == '♌️ Лев'){
                $zodiac = 'lion';
            }
            if($text == '♍️ Дева'){
                $zodiac = 'virgo';
            }
            if($text == '♎️ Весы'){
                $zodiac = 'libra';
            }
            if($text == '♏️ Скорпион'){
                $zodiac = 'scorpio';
            }
            if($text == '♐️ Стрелец'){
                $zodiac = 'sagittarius';
            }
            if($text == '♑️ Козерог'){
                $zodiac = 'capricorn';
            }
            if($text == '♒️ Водолей'){
                $zodiac = 'aquarius';
            }
            if($text == '♓️ Рыбы'){
                $zodiac = 'pisces';
            }

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/general/{$zodiac}/today.html");

            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            // Выполняем поиск совпадений
            if (preg_match($pattern, $homepage, $matches)) {
                // $matches[1] содержит текст, найденный между тегом
                $foundText = $matches[2];
                // Выводим найденный текст
                $horo = trim(stristr($foundText, '<', true));
            } else {
                // Если совпадений не найдено
                $horo = "Гороскоп не найден";
            }

            $dt = Carbon::now();
            $todayDate = str_replace('-','.',$dt->format('d.m.Y')); 

            $this->chat->message("*$text* на $todayDate

🔮 $horo")->send();


            // Добавляем новые кнопки
            $this->chat->message('4')->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('На завтра'),
                ReplyButton::make('На неделю'),
                ])
                ->row([ 
                ReplyButton::make('На месяц'),
                ReplyButton::make('На год'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
              ->where('chat_id', $this->chat->chat_id)
              ->update(['last_zodiac' => 'aries']);
        }


        // Гороскоп на завтра
        if($text == 'На завтра'){

            $userChat = DB::table('telegraph_chats')
            ->select('last_zodiac')->where('chat_id', $this->chat->chat_id)
            ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/general/{$userChat->last_zodiac}/tomorrow.html");

            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            // Выполняем поиск совпадений
            if (preg_match($pattern, $homepage, $matches)) {
                // $matches[1] содержит текст, найденный между тегом
                $foundText = $matches[2];
                // Выводим найденный текст
                $horo = trim(stristr($foundText, '<', true));
            } else {
                // Если совпадений не найдено
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("$horo")->send();

            // Добавляем новые кнопки
            $this->chat->message(1)->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('На завтра'),
                ReplyButton::make('На неделю'),
                ])
                ->row([ 
                ReplyButton::make('На месяц'),
                ReplyButton::make('На год'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
              ->where('chat_id', $this->chat->chat_id)
              ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на неделю
        if($text == 'На неделю'){

            $userChat = DB::table('telegraph_chats')
            ->select('last_zodiac')->where('chat_id', $this->chat->chat_id)
            ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/general/{$userChat->last_zodiac}/week.html");

            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            // Выполняем поиск совпадений
            if (preg_match($pattern, $homepage, $matches)) {
                // $matches[1] содержит текст, найденный между тегом
                $foundText = $matches[2];
                // Выводим найденный текст
                $horo = trim(stristr($foundText, '<', true));
            } else {
                // Если совпадений не найдено
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("$horo")->send();

            // Добавляем новые кнопки
            $this->chat->message(1)->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('На завтра'),
                ReplyButton::make('На неделю'),
                ])
                ->row([ 
                ReplyButton::make('На месяц'),
                ReplyButton::make('На год'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
              ->where('chat_id', $this->chat->chat_id)
              ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на месяц
        if($text == 'На месяц'){

            $userChat = DB::table('telegraph_chats')
            ->select('last_zodiac')->where('chat_id', $this->chat->chat_id)
            ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/general/{$userChat->last_zodiac}/month.html");

            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            // Выполняем поиск совпадений
            if (preg_match($pattern, $homepage, $matches)) {
                // $matches[1] содержит текст, найденный между тегом
                $foundText = $matches[2];
                // Выводим найденный текст
                $horo = trim(stristr($foundText, '<', true));
            } else {
                // Если совпадений не найдено
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("$horo")->send();

            // Добавляем новые кнопки
            $this->chat->message(1)->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('На завтра'),
                ReplyButton::make('На неделю'),
                ])
                ->row([ 
                ReplyButton::make('На месяц'),
                ReplyButton::make('На год'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
              ->where('chat_id', $this->chat->chat_id)
              ->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на год
        if($text == 'На год'){

            $userChat = DB::table('telegraph_chats')
            ->select('last_zodiac')->where('chat_id', $this->chat->chat_id)
            ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/general/{$userChat->last_zodiac}/year.html");

            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            // Выполняем поиск совпадений
            if (preg_match($pattern, $homepage, $matches)) {
                // $matches[1] содержит текст, найденный между тегом
                $foundText = $matches[2];
                // Выводим найденный текст
                $horo = trim(stristr($foundText, '<', true));
            } else {
                // Если совпадений не найдено
                $horo = "Гороскоп не найден";
            }

            $this->chat->message("$horo")->send();

            // Добавляем новые кнопки
            $this->chat->message(1)->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('На завтра'),
                ReplyButton::make('На неделю'),
                ])
                ->row([ 
                ReplyButton::make('На месяц'),
                ReplyButton::make('На год'),
                ])
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')
              ->where('chat_id', $this->chat->chat_id)
              ->update(['last_zodiac' => $userChat->last_zodiac]);
        }


    }
    
}