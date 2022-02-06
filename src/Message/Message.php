<?php

namespace Botpvt\Message;

class Message
{

    /**
     * Path to ini file with messages
     * 
     * @var  const FILE_NAME
     */
    private const FILE_NAME = 'message.ini';
    private array $messageArr = [];

    public function __construct()
    {
        if (file_exists(__DIR__ . '/' . self::FILE_NAME)) {
            $this->messageArr = parse_ini_file(self::FILE_NAME, true);
        } else {
            die("[ini]File with messages not found!");
        }
    }

    /**
     * Show messages
     * Error or Success
     * 
     * @param bool $type
     * @param string $className
     * @param string $messageName
     */
    public function show(
        bool $type = true,
        string $className,
        string $messageName,
        string $messageAdd = ''
    ) {
        if (class_exists($className) or trait_exists($className)) {
            $message = $this->messageArr[$className = (new \ReflectionClass($className))->getShortName()][$messageName] . ' ' . $messageAdd;
            if ($type === false) {
                exit($message);
            } elseif ($type === true) {
                echo  $message;
            }
        }
    }
    public static function find()
    {
        return new static();
    }
}
