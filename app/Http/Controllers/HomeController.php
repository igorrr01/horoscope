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

        $zodiacs = Zodiac::all();
        return view('home', compact('zodiacs'));
    }
}
