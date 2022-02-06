<?php

namespace Botpvt\Widgets;


/**
 * ExchangeRate
 * 
 * Currency exchange rates widget
 * 
 * @author AidSoul
 * @license MIT License
 */
class ExchangeRate extends Widget
{
    /**
     * @var string $str Information output string
     */
    private string $str;

    /**
     * @var string $site site homepage
     */
    private string $site = 'https://www.nbrb.by';

    /**
     * @var string $url link to the bank's api
     */
    private string $url = 'https://www.nbrb.by/api/exrates/rates?periodicity=0';

    /**
     * Forming currency
     * 
     * @return void
     */
    private function chooseСurrency()
    {
        $this->str = '🔥Курсы валют на ' . date("d.m.y") . '🔥' . "\r\n\r\n";
        $typeExist = [431, 451, 456];
        $arr = $this->request($this->url);
        foreach ($arr as $currency) {
            if (in_array($currency->Cur_ID, $typeExist)) {

                $this->str .= "{$currency->Cur_Scale} {$currency->Cur_Abbreviation} = {$currency->Cur_OfficialRate} BYN\r\n";
            }
        }
        $this->str .= "\r\n {$this->site}";
    }

    /**
     * Get a string with the answer
     * 
     * @return string
     */
    public function get(): string
    {
        $this->chooseСurrency();
        return $this->str;
    }
}
