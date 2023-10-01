<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;

class Helper extends Controller
{
    // Транслит зодиака на англ
    public static function zodiacName($text)
    {
        if ($text == '♈️ Овен') {
            $zodiac = 'aries';
        }elseif ($text == '♉️ Телец') {
            $zodiac = 'taurus';
        }elseif ($text == '♊️ Близнецы') {
            $zodiac = 'gemini';
        }elseif ($text == '♋️ Рак') {
            $zodiac = 'cancer';
        }elseif ($text == '♌️ Лев') {
            $zodiac = 'lion';
        }elseif ($text == '♍️ Дева') {
            $zodiac = 'virgo';
        }elseif ($text == '♎️ Весы') {
            $zodiac = 'libra';
        }elseif ($text == '♏️ Скорпион') {
            $zodiac = 'scorpio';
        }elseif ($text == '♐️ Стрелец') {
            $zodiac = 'sagittarius';
        }elseif ($text == '♑️ Козерог') {
            $zodiac = 'capricorn';
        }elseif ($text == '♒️ Водолей') {
            $zodiac = 'aquarius';
        }elseif ($text == '♓️ Рыбы') {
            $zodiac = 'pisces';
        }

        return $zodiac;
    }

    public static function replyKeybordHelperDate()
    {
        return  ReplyKeyboard::make()
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
        ]);
    }

    public static function replyKeybordZodiac()
    {
        return  ReplyKeyboard::make()
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
        ]);
    }

    public static function replyKeybordMainPage()
    {
        return  ReplyKeyboard::make()
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
        ]);
    }

}
