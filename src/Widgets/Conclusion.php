<?php

namespace Botpvt\Widgets;

use Botpvt\Config\Telegram as T;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;


/**
 * Conclusion
 * 
 * Collect and conclusion widgets
 * 
 * @author AidSoul
 * @license MIT License
 */
class Conclusion
{
    /**
     * @var array $widgets Existing widgets
     */
    private array $widgets = ["ExchangeRate", "Weather"];

    /**
     * @var string $str Response string
     */
    private string $str = "";

    /**
     * Sending widgets to the telegram channel
     * 
     * @return void
     */
    public function push()
    {
        new Telegram(T::get()->botApiKey, T::get()->botName);
        foreach ($this->widgets as $type) {
            $strObj = __NAMESPACE__ . "\\" . $type;
            $widget = new $strObj();
            $this->str .= $widget->get();
        }

        $message = Request::sendMessage([
            "chat_id" => T::get()->chatId,
            "text" => $this->str,
        ]);

        Request::pinChatMessage([
            "chat_id" => T::get()->chatId,
            "message_id" => $message->getResult()->message_id,
        ]);
    }
}
