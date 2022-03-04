<?php
namespace Botpvt\DataBase;

use Botpvt\Config\Db;
use \RedBeanPHP\R;

/**
 * Connect
 * 
 * Create connect for database
 * 
 * @author AidSoul
 * @license MIT License
 */
abstract class Connect
{
    /**
     * @var string $tableGroup
     */
    protected string $tableGroup = 'vkgroup';
    
    /**
     * @var string $tablePost
     */
    protected string $tablePost = 'post';

    /**
     * @var string $tableLogs
     */
    protected string $tableLogs = 'log';
    
    public function __construct()
    {
        R::setup(Db::get()->host . ';dbname=' . Db::get()->dbName , Db::get()->user , Db::get()->pass);
        $this->checkTable();
        if (!R::testConnection()) die('No DB connection!');
        R::ext('xdispense', function( $type ){
            return R::getRedBean()->dispense( $type );
        });
    }

    /**
     * !Check Table
     * ?After them
     * Some varible lost, adding for somebody(if needed)
     * 
     *
     * @return void
     */
    private function checkTable(){

        R::exec('
        CREATE TABLE IF NOT EXISTS vkgroup (
        id_group int NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        PRIMARY KEY (id_group)
        );
        CREATE TABLE IF NOT EXISTS post (
        id_post int NOT NULL,
        group_id int NOT NULL,
        CONSTRAINT `past_ibfk` FOREIGN KEY (group_id) REFERENCES vkgroup (id_group)
        );
    ');

    }

}


