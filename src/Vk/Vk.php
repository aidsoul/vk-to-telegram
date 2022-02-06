<?php

namespace Botpvt\Vk;

use Longman\TelegramBot\Telegram;

use Botpvt\Config\Telegram as T;
use Botpvt\Config\Vk as V;

/**
 * Vk
 * 
 * Collect and send
 * 
 * @author AidSoul
 * @license MIT License
 */
class Vk
{
    /**
     * Create new vk object
     *
     * @return object
     */
    private function startVk(): object
    {
        return new \Botpvt\Vk\Api(
            V::get()->token,
            V::get()->idGroup,
            V::get()->count
        );
    }

    /**
     * Set webhook
     * @param \Longman\TelegramBot\Telegram $telega new obj
     * @return void
     */
    private function setWebhook(Telegram $telega)
    {
        if (T::get()->webHook) {
            if (!empty(T::get()->webHook)) {
                $result = $telega->setWebhook(T::get()->hookUrl);
                if ($result->isOk()) {
                    echo $result->getDescription();
                }
            }
        }
    }

    /**
     * Collect and send in telegram channel
     * 
     * @return void
     */
    public function collectPush()
    {
        $sql = new \Botpvt\DataBase\Query();
        $cleanWall = new \Botpvt\Vk\Wall\ReceivedData($this->startVk()::get());
        $telegram = new Telegram(T::get()->botApiKey, T::get()->botName);
        
        // $this->setWebhook($telegram);

        foreach ($cleanWall->getWall() as $item) {

            $id = $item["id"];
            $text = $item["text"];

            if(isset($item["link"])){
                $link = $item["link"];
            }else{
                $link = '';
            }
            
            $sql->checkGroup();

            if (empty($sql->checkPost($id))) 
            {
                // Send data to the telegram channel
                $type = new \Botpvt\Telegram\Send(
                    $text,
                    $id,
                    $link,
                    T::get()->chatId
                );
                $sql->createPost($id);

                foreach ($type->getType() as $typeName) {
                    if (isset($item[$typeName])) {
                        $method = $typeName;
                        $type->$method($item[$typeName]);
                    }
                }

                // logging
                // $sql->createLog(
                //     "success",
                //     "Пост {$id} создан: " . date("Y-m-d H:i:s")
                // );

            }
        }
    }
}
