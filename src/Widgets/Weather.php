<?php

namespace Botpvt\Widgets;


/**
 * Weather
 * 
 * Widget Weather
 * 
 * !!! In Work !!!
 * 
 * @author AidSoul
 * @license MIT License
 */
class Weather extends Widget
{
    private string $url = "https://api.weather.yandex.ru/v2/informers?";

    private function chooseWeather()
    {
        $lat = 0;
        $lon = 0;
        $lang = "ru_RU";

        $this->request("{$this->url}lat={$lat}&lon={$lon}&lang={$lang}");
    }

    public function get(): string
    {
        return "";
    }
}
