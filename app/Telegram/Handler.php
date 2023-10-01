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

            $this->chat->message('1')->replyKeyboard(
                ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('💟 Любовный гороскоп'),
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
        } else {
            $this->reply('Неизвестная команда');
        }
    }


    // Обрабатываем входящие сообщения
    protected function handleChatMessage(Stringable $text): void
    {
        if ($text == '🏠 Главное меню') {
            $this->chat->message('🏠 Главное меню')->replyKeyboard(
                ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('💟 Любовный гороскоп'),
                        ReplyButton::make('🔮 Гороскоп'),
                    ])
                    ->row([
                        ReplyButton::make('🪬 Хиромантия'),
                        ReplyButton::make('🀄️ Карты таро'),
                    ])
                    ->row([
                        ReplyButton::make('🏵 Восточный гороскоп'),
                    ])
            )
                ->send();
        }

        if ($text == '🪬 Хиромантия') {
            $this->chat->message('*Линии на ладони подскажут, какая судьба Вас ожидает. Познакомьтесь с основами китайской хиромантии, научитесь читать линии на руке и узнайте, какими бывают: линия жизни, линия судьбы, линия брака, линия любви!*

Хиромантия основывается главным образом на изучении формы, цвета и линии на ладони, а также длины пальцев. Некоторые хироманты также принимают во внимание узоры на подушечках пальцев.
Гадание по руке позволяет определить удачу или неудачу. Ваша рука, линия на ладони и знания опытного хироманта помогут узнать о жизни и судьбе и лучше понять себя.
            ')->photo(Storage::path('hiro1.webp'))->replyKeyboard(
                ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('💟 Любовный гороскоп'),
                        ReplyButton::make('🔮 Гороскоп'),
                    ])
                    ->row([
                        ReplyButton::make('🪬 Хиромантия'),
                        ReplyButton::make('🀄️ Карты таро'),
                    ])
                    ->row([
                        ReplyButton::make('🏵 Восточный гороскоп'),
                    ])
            )
                ->send();

                $this->chat->message('*1. Линия жизни - чем длиннее, тем лучше*
Линия жизни - её также называют "линией земли". это линия, которая проходит вокруг большого пальца. Обычно это дуга. Длина линии жизни не имеет отношения к продолжительности жизни человека. Он отражает здоровье и физическую жизнеспособность.
Линия жизни - это линия, которая проходит вокруг большого пальца. Обычно это дуга. Длина линии жизни не имеет отношения к продолжительности жизни человека. Он отражает здоровье и физическую жизнеспособность.
            ')->photo(Storage::path('hiro2.webp'))->send();
                $this->chat->message('Если линия жизни имеет большую дугу и выглядит четкой, это означает, что человек энергичен. Чем длиннее линия жизни, тем лучше. Люди с длинной линией жизни обычно хорошо занимаются спортом.
Если линия жизни имеет небольшую дугу и находится рядом с большим пальцем, это означает, что этот человек не здоров и быстро устает.
            ')->photo(Storage::path('hiro3.webp'))->send();

                $this->chat->message('Если имеется более одной линии жизни, это также указывает на то, что человек очень полон жизни.
Если начало линии жизни (около перепонки большого пальца) обрывается, он часто болел в детстве.
Если конец линии жизни (около запястья) выглядит потрепанным, ему следует уделять больше внимания на здоровье, когда он стареет.
Если на линии есть круг (например, остров) или линия где-то разрезана, он / она может получить физическую травму или оказаться в больнице. Размер круга отражает серьезность болезни / травмы.
Если линия жизни прямая и пересекает ладонь параллельно линии головы, он / она храбрый и обычно очень общительный человек.
            ')->photo(Storage::path('hiro4.webp'))->send();

            sleep(2);
                $this->chat->message('*2. Линия сердца (линия любви) - чем длиннее, тем лучше.*
Линия сердца, которую иногда называют линией любви, - это линия, проходящая через руку прямо под пальцами. Линия сердца отражает вещи, связанные с сердцем, такие как чувства, реакции, контроль над эмоциями и т. Д. Чем длиннее и прямее она, тем лучше.
Линия любви также называется "небесной линией",
Если линия сердца короткая и прямая, он / она мало заинтересованы в выражении любви или романтики.
Если линия сердца длинная, он, вероятно, будет хорошим любовником - милым, понимающим и романтичным.
            ')->photo(Storage::path('hiro5.webp'))->send();

                $this->chat->message('Если линия сердца начинается от указательного пальца, предсказывается счастливый любов.
Если он начинается со среднего пальца, это означает, что человек обычно думает о себе больше, чем о своем возлюбленном.
Если линия сердца имеет большой подъем и падение, он / она, вероятно, влюбится в нескольких человек.Каждая история любви обычно длится недолго.
Если на линии сердца есть один или несколько кругов, линия сердца разделена на несколько частей или есть несколько коротких тонких линий, пересекающих линию сердца, это обычно означает, что он / она не очень доволен своей нынешней любовной жизнью.
            ')->photo(Storage::path('hiro6.webp'))->send();

            sleep(2);
                $this->chat->message('*3. Линия Судьбы - Чистая и прямая - это хорошо.*
Линия Судьбы, также называемая Денежная линия, "линией карьеры",- это линия, которая проходит от запястья до среднего пальца и отражает состояние и карьеру.
Если линия Судьбы и линия жизни начинаются с одной и той же точки, этот человек обычно амбициозен и имеет сильную уверенность в себе.
Если есть две линии Судьбы, он / она может иметь две работы вместе или побочный бизнес.
            ')->photo(Storage::path('hiro7.webp'))->send();

                $this->chat->message('Если линия Судьбы выглядит четкой и прямой, это обычно означает хорошее и счастливое будущее.
Линия Судьбы разделена на два или более разделов. Это означает, что этот человек, вероятно, будет часто менять работу или в его / ее жизни / карьере произойдут большие изменения.
Если линия Судьбы короткая, это означает, что он / она может перестать работать до выхода на пенсию.
            ')->photo(Storage::path('hiro8.webp'))->send();

                $this->chat->message('*4. Линия умы - чем четче и длиннее, тем лучше.*
Линия умы отражает интеллект и менталитет человека. Обычно она начинается между указательным и большим пальцами (ниже линии любви), а затем тянется к другой стороне ладони, как будто она разделяет ладонь пополам.
Четкость, тонкость и длина линии умы отражают умственную концентрацию и сообразительность.
Большая дуга линии умы говорит нам о том, что он / она богаты творчеством.
Короткая линия умы обычно означает, что у человека больше шансов на физические достижения, чем на умственные.
Если на линии умы есть круг, линия умы разрезана на две (или более) части или линия умы колеблется, у него / нее сравнительно плохая память, его легко беспокоят другие и обычно он не сосредотачивается на что угодно надолго.
            ')->photo(Storage::path('hiro9.webp'))->send();

            sleep(2);

                $this->chat->message('*5. Линия брака*
Линия брака - это короткая линия над линией любви, начинающаяся сразу под мизинцем. Она отражает романтические отношения и брак.
У кого-то здесь только одна линия, у кого-то несколько строк.Количество строк ничего не значит. Просто прочтите самую четкую.
Если есть две одинаково четкие линии брака, ему нужно остерегаться любовного треугольника.
Если есть несколько линий брака без основной, его семейная жизнь может быть нерадостной.
            ')->photo(Storage::path('hiro10.webp'))->send();

                $this->chat->message('Если очередь идет вверх или короткая и неглубокая, обычно он / она не будет жениться или женится очень поздно.
Если линия брака тянется до мизинца или безымянного пальца, у этого человека высокие требования при выборе супруга.
Если линия брака тянется до безымянного пальца, это говорит о том, что семья его / ее супруга богата и дружна.
Однако если линия брака тянуться дальше третьего пальца - нехорошо: брак может сказаться на репутации и богатстве.
            ')->photo(Storage::path('hiro11.webp'))->send();

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
                ->replyKeyboard(
                    ReplyKeyboard::make()
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
            $todayDate = str_replace('-', '.', $dt->format('d.m.Y'));

            $this->chat->message("*$text* на $todayDate

🔮 $horo")->replyKeyboard(
                ReplyKeyboard::make()
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
                ->update([
                    'last_zodiac' => $zodiac,
                    // 'horoscope_type' => $horoscope_type,
                ]);
        }


        // Гороскоп на завтра
        if ($text == 'На завтра') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/tomorrow.html");

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

            $this->chat->message("🔮 $horo")->replyKeyboard(
                ReplyKeyboard::make()
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
        if ($text == 'На неделю') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/week.html");

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

            $this->chat->message("🔮 $horo")->replyKeyboard(
                ReplyKeyboard::make()
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
        if ($text == 'На месяц') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/month.html");

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

            $this->chat->message("🔮 $horo")->replyKeyboard(
                ReplyKeyboard::make()
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
        if ($text == 'На год') {

            $userChat = DB::table('telegraph_chats')
                ->select('last_zodiac', 'horoscope_type')->where('chat_id', $this->chat->chat_id)
                ->first();

            $homepage = file_get_contents("https://orakul.com/horoscope/astrologic/{$userChat->horoscope_type}/{$userChat->last_zodiac}/year.html");

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

            $this->chat->message("🔮 $horo")->replyKeyboard(
                ReplyKeyboard::make()
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

        // Обновляем дату последнего запроса к боту
        DB::table('telegraph_chats')
        ->where('chat_id', $this->chat->chat_id)
        ->update(['updated_at' => Carbon::now()]);
    }
}
