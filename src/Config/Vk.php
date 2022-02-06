<?php

namespace Botpvt\Config;

use Botpvt\Message\Message;

class Vk extends Config
{
    use ActionConfig;

    private string $token;
    private string $idGroup;
    private int $count;

    private function count(): bool
    {
        if (isset($this->count) and $this->count > 100) {
            Message::find()->show(false, __CLASS__, 'count');
        } else {
            return true;
        }
    }
}
