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

class Handler extends WebhookHandler
{

    // Обрабатываем команды
    public function hello()
    {
        $this->reply('Привет! Это первое сообщение :)');
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

        if($text == '♈️ Овен'){
            $this->chat->message('
♈️ Овен на 23.09.2023

🔮 День подойдет для решения многих серьезных вопросов. Вы сразу сосредоточитесь на главном, не станете ни тратить время напрасно, ни отвлекаться на мелочи. Очень кстати рядом окажутся люди, чьи опыт и знания окажутся вам полезны. Они помогут успешно завершить дело, которому вы уже отдали немало сил.
            
🔮 Благоприятным день будет и для поездок. Они сложатся особенно удачно, если вы отправитесь в дорогу вместе с кем-то из близких. Если любимый человек составит вам компанию, путешествие будет просто незабываемым.
            ')->send();

            // Добавляем новые кнопки
            $this->chat->message('3')->replyKeyboard(ReplyKeyboard::make()
                ->row([ 
                ReplyButton::make('🏠 Главное меню'),
                ])
            )
            ->send();            

        }


    }
    
}