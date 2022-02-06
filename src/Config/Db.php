<?php

namespace Botpvt\Config;

class Db extends Config
{
    use ActionConfig;

    private string $host;
    private string $dbName;
    private string $user;
    private string $pass;
}
