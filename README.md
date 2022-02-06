# vk-to-telegram

>Parser of groups of the social network "VKontakte", followed by sending data to the channel of the messenger "Telegram".

## Implemented

>Photo attachments;
>
>Text;
>
>Widgets;
  >>>Currency rates `Only for the State of Belarus`;
  >>>
  >>>Weather;
>
>Admin Panel `Available in the full version`;
>
>Parsing reposts from other VK communities;

## Not implemented

>At the moment, there is no possibility of parsing the video!
>
>The code is not optimized.

## Installation

To install, use the command: `git clone https://github.com/aidsoul/vk-to-telegram`.

Download the necessary libraries using the command: `composer install`.

Or use command `composer require aidsoul/botpvt`.

## Connection example
```php
require_once __DIR__.'/vendor/autoload.php';
$config =  [
    'Vk'        =>[
   	    'token'         => 'Your token',
   	    'idGroup'       => 'Group id or name',
   	    'count'         => 5
    ],
    'Telegram'  =>[
      	'botApiKey'     => '',
      	'botName'       => '',
     	  'chatId'        =>  0
    ],
    'Db'        =>[
       	'host'          => 'mysql:host=localhost',
       	'dbName'        =>  'vk',
        'user'          =>  'root',
        'pass'          =>  ''
      ],
  ];

Botpvt\Start::vk($config);
```

## Widgets

```php 
require_once __DIR__.'/vendor/autoload.php';
use Botpvt\Config\Config;
// Combining all widgets into text and pinning in the channel
/**/
Config::set($config);
$con = new Botpvt\Widgets\Conclusion;
$con->push();
```
If you need to send only a specific widget, use:
```php
$widget = Botpvt\Widgets\ExchangeRate;
// get a string with the answer
$str = $widget->get();
```
>This method does not send data to the telegram channel!

## MySQL

>The project uses a mysql database.

And finally, import the database file: `db.sql`.


## Task Scheduler

>Use crontab on your server or another task scheduler to get fresh posts without stopping.

### Usage example

Open and add a task to the task list: `crontab-e`.
Get fresh entries every minute: `* * * * * php /patch for php file`.