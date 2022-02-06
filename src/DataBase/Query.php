<?php

namespace Botpvt\DataBase;

use \RedBeanPHP\R;

/**
 * Query
 * 
 * Post related queries
 * 
 * @author AidSoul
 * @license MIT License
 */
class Query extends Connect
{

    private string $groupId;

    /**
     * Adding a Group table
     * 
     * @return array
     */
    public function createGroup(): void
    {
        $id = (new \Botpvt\Config\Vk)::get()->idGroup;
        R::exec("INSERT INTO {$this->tableGroup} VALUES (NULL,:name)", ["name" => $id]);
        $this->checkGroup();
    }


    /**
     * Checking the existence of a post 
     * 
     * @param int $postId
     * 
     * @return void 
     */
    public function checkGroup(): void
    {
        $id = (new \Botpvt\Config\Vk)::get()->idGroup;
        $str = R::getCell("SELECT id_group FROM {$this->tableGroup} WHERE name = ? LIMIT 1", [$id]);
        if (!empty($str)) {
            $this->groupId = $str;
        } else {
            $this->createGroup();
        }
    }


    /**
     * Adding a post table
     * 
     * @param int $id
     * @param string $text
     * 
     * @return void
     */
    public function createPost(int $postId): void
    {
        R::exec(
            "INSERT INTO {$this->tablePost} VALUES (:postId,:groupId)",
            ['postId' => $postId, 'groupId' => $this->groupId]
        );
    }

    /**
     * Checking the existence of a post 
     * 
     * @param int $postId
     * 
     * @return bool 
     */
    public function checkPost(int $postId)
    {
        return R::getCell(
            "SELECT id_post FROM {$this->tablePost} WHERE id_post = ? and group_id = ? LIMIT 1",
            [$postId, $this->groupId]
        );
    }

    /**
     * Logging
     * 
     * @param string $typeLog
     * @param string $message
     * 
     * @return  void
     */
    public function createLog(string $typeLog, string $message): void
    {
        R::exec(
            "INSERT INTO {$this->tableLogs} VALUES (:type,:message)",
            [
                'type' => $typeLog,
                'message' => $message,
            ]
        );
    }
}
