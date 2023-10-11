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

    public function atb()
    {
        // Парсим ссылку на акцию
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.lovesales.com.ua/aktsiyni-katalogy/atb");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);
        curl_close($ch); 
        
    
        preg_match('/АТБ-Маркет<\/h3><\/a><a href="(.*?)Економія/s', $output, $first);
        $second = mb_substr($first[1], -200);
        preg_match('/<a href="(.*?)">/s', $second, $third);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.lovesales.com.ua$third[1]");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $four = curl_exec($ch);
        curl_close($ch); 
    
        preg_match('/<meta property="og:image" content=(.*?)\/>/s', $four, $five);

        if(empty($five))
        {
            $this->chat->message("Скидки появятся через несколько часов")->send();
        }
    
        // Убираем кавычки с начала и конца URL
        $six = mb_substr($five[1], 1, -1);
    
        $url[] = $six;
        $url[] = mb_substr($six, 0, -5) . 2 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 3 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 4 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 5 . '.jpg';

        if(empty($url))
        {
            $this->chat->message("Скидки появятся через несколько часов")->send();
        }else{

            $this->chat->photo("$url[0]")->send();
            sleep(1);
            $this->chat->photo("$url[1]")->send();
            sleep(1);
            $this->chat->photo("$url[2]")->send();
            sleep(1);
            $this->chat->photo("$url[3]")->send();
            sleep(1);
            $this->chat->photo("$url[4]")->send();
        }

    }

    public function eco()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.lovesales.com.ua/aktsiyni-katalogy/eko");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);
        curl_close($ch); 
    
        preg_match('/ЕКО-маркет<\/h3><\/a><a href="(.*?)Каталог/s', $output, $first);
        $second = mb_substr($first[1], -200);
        preg_match('/<a href="(.*?)">/s', $second, $third);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.lovesales.com.ua$third[1]");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $four = curl_exec($ch);
        curl_close($ch); 
    
        preg_match('/<meta property="og:image" content=(.*?)\/>/s', $four, $five);
        
        if(empty($five))
        {
            $this->chat->message("Скидки появятся через несколько часов")->send();
        }
    
        // Убираем кавычки с начала и конца URL
        $six = mb_substr($five[1], 1, -1);
    
        $url[] = $six;
        $url[] = mb_substr($six, 0, -5) . 2 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 3 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 4 . '.jpg';
        $url[] = mb_substr($six, 0, -5) . 5 . '.jpg'; 
        $url[] = mb_substr($six, 0, -5) . 6 . '.jpg'; 
        $url[] = mb_substr($six, 0, -5) . 7 . '.jpg'; 
        $url[] = mb_substr($six, 0, -5) . 8 . '.jpg'; 
        $url[] = mb_substr($six, 0, -5) . 9 . '.jpg'; 
        $url[] = mb_substr($six, 0, -6) . 10 . '.jpg'; 
        $url[] = mb_substr($six, 0, -6) . 11 . '.jpg'; 
        $url[] = mb_substr($six, 0, -6) . 12 . '.jpg'; 
        $url[] = mb_substr($six, 0, -6) . 13 . '.jpg'; 
        $url[] = mb_substr($six, 0, -6) . 14 . '.jpg'; 

        $this->chat->photo("$url[0]")->send();
        sleep(1);
        $this->chat->photo("$url[1]")->send();
        sleep(1);
        $this->chat->photo("$url[2]")->send();
        sleep(1);
        $this->chat->photo("$url[3]")->send();
        sleep(1);
        $this->chat->photo("$url[4]")->send();
        sleep(1);
        $this->chat->photo("$url[5]")->send();
        sleep(1);
        $this->chat->photo("$url[6]")->send();
        sleep(1);
        $this->chat->photo("$url[7]")->send();
        sleep(1);
        $this->chat->photo("$url[8]")->send();
        sleep(1);
        $this->chat->photo("$url[9]")->send();
        sleep(1);
        $this->chat->photo("$url[10]")->send();
        sleep(1);
        $this->chat->photo("$url[11]")->send();
        sleep(1);
        $this->chat->photo("$url[12]")->send();
        sleep(1);
        $this->chat->photo("$url[13]")->send();
/*         sleep(1);
        $this->chat->photo("$url[14]")->send(); */
    }

    // Обрабатываем неизвестные команды
    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() === '/start') {
            $this->chat->message('
*Привет! Я - гороскоп бот ✨*

Я предскажу твой день на завтра, проверю вашу совместимость с партнером, а также сделаю расклад на картах Таро 🔮
            ')->photo(Storage::path('start_logo.jpeg'))->replyKeyboard(Helper::replyKeybordMainPage())->send();

        } else {
            $this->reply('Неизвестная команда');
        }
    }


    public function taroSend(){
        Helper::taroList($this->chat);
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

        if ($text == '🏵 Китайский гороскоп') {
            $this->chat->message('🔆 Выберете животное по году Вашего рождения и получите предсказание на год')->photo(Storage::path("china_horoscope2.jpg"))->replyKeyboard(Helper::replyKeybordEastMainPage())->send();
        }

        if ($text == '🀄️ Карты таро') {
            $this->chat->message('🀄️ Выбери карту, которая понравилась больше всего 👀')->photo(Storage::path("taro_main.jpg"))
            ->keyboard(Keyboard::make()->buttons([
                Button::make("2 💫")->action("taroSend")->param('id', 1),  
                Button::make("1 💫")->action("taroSend")->param('id', 2),  
                Button::make("3 💫")->action("taroSend")->param('id', 3),  
            ])->chunk(3))->send();
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
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->update(['horoscope_type' => $horoscope_type]);
        }

        // Китайски гороскоп
        if($text == 'Свинья' || $text == 'Крыса' || $text == 'Вол' || $text == 'Тигр'
            || $text == 'Заяц (Кот)' || $text == 'Дракон' || $text == 'Змея' || $text == 'Лошадь'
            || $text == 'Коза' || $text == 'Обезьяна' || $text == 'Петух' || $text == 'Собака'){

            // Получаем названия зодиака на англ.
            $zodiac = Helper::ChinazodiacName($text);
            
                $homepage = file_get_contents("https://orakul.com/horoscope/chinese/general/{$zodiac}/year.html");
                $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
                if (preg_match($pattern, $homepage, $matches)) {
                    $foundText = $matches[2];
                    $horo = trim(stristr($foundText, '<', true));
                } else {
                    $horo = "Гороскоп не найден";
                }

                $dt = Carbon::now();
                $todayDate = str_replace('-', '.', $dt->format('d.m.Y'));

                $this->chat->message("*Китайский гороскоп 🔆 $text* на $todayDate

🔮 $horo")->replyKeyboard(Helper::replyKeybordMainPage())->send();

        }


        if($text == '♈️ Овен' || $text == '♉️ Телец' || $text == '♊️ Близнецы' || $text == '♋️ Рак'
            || $text == '♌️ Лев' || $text == '♍️ Дева' || $text == '♎️ Весы' || $text == '♏️ Скорпион'
            || $text == '♐️ Стрелец' || $text == '♑️ Козерог' || $text == '♒️ Водолей' || $text == '♓️ Рыбы'){

            // Получаем названия зодиака на англ.
            $zodiac = Helper::zodiacName($text);

            $userChat = DB::table('telegraph_chats')->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$zodiac}/today.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $horoscope_base = DB::table('horoscope_base')->select('id')->where('text', $horo)->first();
            if(!$horoscope_base){
                DB::table('horoscope_base')->insert([
                    'text' => $horo,
                    'h_type' => $userChat->horoscope_type,
                    'zodiac' => $zodiac,
                    'time_type' => 'today',
                    'time' => Carbon::now(),
                ]);
            }


            $dt = Carbon::now();
            $todayDate = str_replace('-', '.', $dt->format('d.m.Y'));

            $this->chat->message("*$text* на $todayDate

🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['last_zodiac' => $zodiac]);
        }

        // Гороскоп на завтра
        if ($text == 'На завтра') {

            $userChat = DB::table('telegraph_chats')->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/tomorrow.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $horoscope_base = DB::table('horoscope_base')->select('id')->where('text', $horo)->first();
            if(!$horoscope_base){
                DB::table('horoscope_base')->insert([
                    'text' => $horo,
                    'h_type' => $userChat->horoscope_type,
                    'zodiac' => $userChat->last_zodiac,
                    'time_type' => 'tomorrow',
                    'time' => Carbon::now(),
                ]);
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на неделю
        if ($text == 'На неделю') {

            $userChat = DB::table('telegraph_chats')->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/week.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $horoscope_base = DB::table('horoscope_base')->select('id')->where('text', $horo)->first();
            if(!$horoscope_base){
                DB::table('horoscope_base')->insert([
                    'text' => $horo,
                    'h_type' => $userChat->horoscope_type,
                    'zodiac' => $userChat->last_zodiac,
                    'time_type' => 'weekly',
                    'time' => Carbon::now(),
                ]);
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на месяц
        if ($text == 'На месяц') {

            $userChat = DB::table('telegraph_chats')->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/month.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            $horoscope_base = DB::table('horoscope_base')->select('id')->where('text', $horo)->first();
            if(!$horoscope_base){
                DB::table('horoscope_base')->insert([
                    'text' => $horo,
                    'h_type' => $userChat->horoscope_type,
                    'zodiac' => $userChat->last_zodiac,
                    'time_type' => 'monthly',
                    'time' => Carbon::now(),
                ]);
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Гороскоп на год
        if ($text == 'На год') {

            $userChat = DB::table('telegraph_chats')->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/year.html");
            $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
            if (preg_match($pattern, $homepage, $matches)) {
                $foundText = $matches[2];
                $horo = trim(stristr($foundText, '<', true));
            } else {
                $horo = "Гороскоп не найден";
            }

            if($horo == 'Первый квартал'){
                $pattern = '/<div class="horoBlock">(.*?)>(.*?)iv>/s';
                // Выполняем поиск совпадений
                if (preg_match($pattern, $homepage, $matches)) {
                    // $matches[1] содержит текст, найденный между тегом
                    $foundText = $matches[2];
                    // Выводим найденный текст
                    $horo = trim(stristr($foundText, 'p', true));
                    $horo = str_replace('<br />', ' ', $horo);
                } else {
                    // Если совпадений не найдено
                    $horo = "Гороскоп не найден";
                }
            }

            $horoscope_base = DB::table('horoscope_base')->select('id')->where('text', $horo)->first();
            if(!$horoscope_base){
                DB::table('horoscope_base')->insert([
                    'text' => $horo,
                    'h_type' => $userChat->horoscope_type,
                    'zodiac' => $userChat->last_zodiac,
                    'time_type' => 'year',
                    'time' => Carbon::now(),
                ]);
            }

            $this->chat->message("🔮 $horo")->replyKeyboard(Helper::replyKeybordHelperDate())->send();

            // Обновляем последний гороскоп в БД
            DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['last_zodiac' => $userChat->last_zodiac]);
        }

        // Обновляем дату последнего запроса к боту
        DB::table('telegraph_chats')->where('chat_id', $this->chat->chat_id)->limit(1)->update(['updated_at' => Carbon::now()]);
    }
}
