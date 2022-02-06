<?php

namespace Botpvt;

/**
 * Start
 *
 * Starting parsing and sending
 */
class Start
{
    /**
     * @param array $config
     *
     * @return void
     */
    public static function vk(array $config = [])
    {
        \Botpvt\Config\Config::set($config);
        $vk = new \Botpvt\Vk\Vk;
        $vk->collectPush();
    }
}
