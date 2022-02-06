<?php

namespace Botpvt\Telegram;

use Longman\TelegramBot\Request;


/**
 * Send
 * 
 * Sending data to the telegram channel
 * 
 * @author AidSoul
 * @license MIT License
 */
class Send
{
    /**
    * @param object $sql Object for working with the database
    * @param string $text Text of the post
    * @param int $id Post id
    * @param int $chatId Channel id
    */
    public function __construct(
        // private object $sql,
        private string $text,
        private int $id,
        private string $link,
        private int $chatId
    ) {
    }

    /**
     * !The order of placement in the array is important
     * !The first type will be processed first
     * 
     * @var array $type Types to send
     */
    private array $type = ["author", "media", "link", "text"];

    /**
     * Get types to send
     * 
     * @return array
     */
    public function getType(): array
    {
        return $this->type;
    }

    /**
     * Sending text
     * 
     * @return void
     */
    public function text()
    {   
        if (!empty($this->text)) {
            Request::sendMessage([
                "chat_id" => $this->chatId,
                "text" => $this->text,
            ]);
        }
    }

    /**
     * Creating link
     * Afrer sending for the chat
     * 
     * @return void
     */
    public function link()
    {
        $this->text = $this->text . "\r\n". $this->link;
    }

    /**
     * Sending author id in vk
     * Forming author link
     * 
     * @param int $authorId id author
     * 
     * @return void
     */ 
    public function author(int $authorId)
    {
        $this->text = $this->text . "\r\n✍ https://vk.com/id{$authorId} ✍";
    }

    /**
     * Sending media attachments
     * 
     * @param array $media media attachments
     * 
     * @return void
     */  
    public function media(array $media) 
    {
        $media[0]["caption"] = $this->text;

        Request::sendMediaGroup([
            "chat_id" => $this->chatId,
            "media" => $media,
        ]);
        
        $this->text = '';
        // foreach ($media as $img) {
        //     $this->sql->createImage(str_replace('https://','',$img["media"]), $this->id);
        // }
    }
}

