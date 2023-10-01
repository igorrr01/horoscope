<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
