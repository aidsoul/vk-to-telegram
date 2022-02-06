<?php
namespace Botpvt\Vk\Wall;

/**
 * Wall
 *
 * Creating a clean array
 *
 * @author AidSoul
 * @license MIT Licens
 */

class Wall
{
    /**
     * @var array $wall
     */
    private array $cleanWall = [];

    /**
     * @var int $id
     */
    protected int $id;

    /**
     * @var string $text
     */
    protected string $text;

    /**
     * @var string $author
     */
    protected string $author;

    protected function del(string $item = null)
    {
        unset($this->cleanWall[$item]);
    }

    protected function id(int $id = null)
    {
        $this->id = $id;
        $this->cleanWall[$this->id]["id"] = $this->id;
    }

    protected function text(string $text = null)
    {
        $this->text = $text;
        $this->cleanWall[$this->id]["text"] = $text;
    }

    protected function author(int $author = null)
    {
        $this->cleanWall[$this->id]["author"] = $author;
    }
    
    protected function link(string $url)
    {
        $this->cleanWall[$this->id]["link"] = $url;
    }
    

    /**
     * Creating an array with media attachments
     *
     * @return void
    */
    protected function media(
        string $type,
        string $mediaType,
        string $caption = ""
    ) {
        $this->cleanWall[$this->id]["media"][] = [
            "type" => $type,
            "media" => $mediaType,
            "caption" => $caption,
        ];
    }
    
    /**
     * Return clean wall array
     *
     * @return array
    */
    protected function wall(): array
    {
        return $this->cleanWall;
    }
}
