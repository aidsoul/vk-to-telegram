<?php
namespace Botpvt\Config;

class Telegram extends Config
{
    use ActionConfig;

    private string $botApiKey;
    private string $botName;
    private int $chatId;
    private bool $webHook;
    private string $hookUrl;
}
