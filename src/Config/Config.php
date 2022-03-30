<?php
namespace Botpvt\Config;

class Config
{
   protected static array $config  = [];

   public static function set(array $сonfig)
   {
      self::$config = $сonfig;
   }
}
