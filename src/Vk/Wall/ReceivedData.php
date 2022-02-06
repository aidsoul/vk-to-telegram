<?php

namespace Botpvt\Vk\Wall;

use Botpvt\Vk\Wall\Wall;

/**
 * ReceivedData
 * 
 * Processing an array of a wall
 * 
 * @author AidSoul
 * @license MIT License
 */
class ReceivedData extends Wall
{
    /**
     * @var string[] $blockAttach Unwanted parameters in @param array $wall
     */
    private $blockAttach = ["poll", "video"];

    /**
     * @var int $сounterImg Photo сounter
     */
    private $сounterImg = 0;

    /**
     * @param array $wall Array from the group wall
     */
    public function __construct(private object $wall)
    {
    }

    /**
     * Iterating through a nested array of attachments
     *
     * @param array $data
     * @return void
     */
    private function attachForeach(array $data)
    {
        foreach ($data as $attach) {

            foreach ($this->blockAttach as $block) {
                if (isset($attach->$block)) {
                    $this->del($this->id);
                }
            }

            if ($attach->type == "photo") {
                $this->сounterImg++;
            }

            if (isset($attach->link)) {
                $this->link($attach->link->url);
            }

            if (isset($attach->photo)) {
                $this->media("photo", end($attach->photo->sizes)->url);
            }
        }
        // Resetting the image counter
        $this->сounterImg = 0;
    }

    /**
     *
     * Processing original post array
     * 
     * @param array $PostItem 
     * 
     * @return void
     */
    private function standartType(object $postItem)
    {
        $text = $postItem->text;

        $this->id($postItem->id);
        $this->text($text);

        // add author if exist
        if (isset($postItem->signer_id)) {
            if (isset($text) || isset($postItem->attachments)) {
                $this->author($postItem->signer_id);
            }
        }

        if (isset($postItem->attachments)) {
            $this->attachForeach($postItem->attachments, $text);
        }
    }

    /**
     * Processing a Repost record
     *
     * In array $wall contains an array 'copy_history'
     * if there is a post on the wall from another community
     * this function will be used
     *
     * @param mixed $copyitem
     *  
     * @return void
     */
    private function copyHistory(object $copyitem): void
    {
        foreach ($copyitem->copy_history as $nItem) {
            $this->standartType($nItem);
            $this->del($copyitem->id);
        }
    }

    /**
     * Iterating over an array $wall
     *
     * @return void
     */
    public function ok(): void
    {
        foreach ($this->wall->response->items as $i) {
            if (isset($i->copy_history)) {
                $this->copyHistory($i);
            } else {
                $this->standartType($i);
            }
        }
    }

    /**
     * Getting a cleaned array
     *
     * @return array
     *
     */
    public function getWall(): array
    {
        //collect wall data in one array
        $this->ok();
        //send received data 
        return $this->wall();
    }
}
