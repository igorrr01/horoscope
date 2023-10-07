<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zodiac;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        function file_get_contents_curl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
            curl_setopt($ch, CURLOPT_URL, $url);
            $data = curl_exec($ch);
            curl_close($ch);
            return json_decode($data);
        }
        $json = file_get_contents_curl('http://www.boredapi.com/api/activity/');
        //dd($json->activity);

/*         $homepage = file_get_contents('https://orakul.com/horoscope/astrologic/general/aries/today.html');

        $pattern = '/<div class="horoBlock">(.*?)>(.*?)<\/div>/s';
        // Выполняем поиск совпадений
        if (preg_match($pattern, $homepage, $matches)) {
            // $matches[1] содержит текст, найденный между тегом
            $foundText = $matches[2];
            // Выводим найденный текст
            $horo = trim(stristr($foundText, '<', true)));
        } else {
            // Если совпадений не найдено
            $horo = "Гороскоп не найден";
        }

        dd($homepage); */

/*     $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://gotoshop.ua/ru/kiev/shops/atb/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $output = curl_exec($ch);
    curl_close($ch); 

    // Получаем ссылку на текущую акцию
    preg_match('/<div class="discount-item less-two">(.*?)Акція "Економія"/s', $output, $first);
    $second = mb_substr($first[1], -250);
    preg_match('/<a href="(.*?)" title/s', $second, $third); */
    //dd($third[1]);

    // Парсим текущю акцию

/*     $parseUrl = "https://gotoshop.ua$third[1]";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $parseUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $output = curl_exec($ch);
    curl_close($ch);  */

/*     $ch = curl_init();
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

    // Убираем кавычки с начала и конца URL
    $six = mb_substr($five[1], 1, -1);

    $url[] = $six;
    $url[] = mb_substr($six, 0, -5) . 2 . '.jpg';
    $url[] = mb_substr($six, 0, -5) . 3 . '.jpg';
    $url[] = mb_substr($six, 0, -5) . 4 . '.jpg';
    $url[] = mb_substr($six, 0, -5) . 5 . '.jpg';

    dd($url); */

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

    dd($url);



        $zodiacs = Zodiac::all();
        return view('home', compact('zodiacs'));
    }
}
