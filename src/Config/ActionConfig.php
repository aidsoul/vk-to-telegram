<?php

namespace Botpvt\Config;

use Botpvt\Message\Message;

/**
 * ActionConfig
 *
 * Get config with name
 *
 * @author AidSoul
 * @license MIT License
 */

trait ActionConfig
{
    public function __get($property)
    {
        $className = (new \ReflectionClass($this))->getShortName();
        //remove null
        $item = (@parent::$config[$className][$property]);
        if (array_key_exists($className, parent::$config) and property_exists($this, $property) === true) {
            if (preg_match("/[<\/][a-zA-Z]{1,7}[>]+/", $item)) {
                Message::find()->show(false, __TRAIT__, 'tag', "{$item}");
            }
            @$this->$property = $item;
            if (
                !method_exists($this, $property) or
                method_exists($this, $property) and
                $this->$property() === true
            ) {
                return $this->$property;
            }
        } else {
            Message::find()->show(false, __TRAIT__, 'property', "[{$className}->[{$property}=>'...']");
        }
    }

    public static function get()
    {
        return new static();
    }
}
