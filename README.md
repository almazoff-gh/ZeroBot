# Документация по ZeroBot
Библиотека по созданию ботов, упрощает вам жизнь, вы можете очень быстро и легко сделать из вашего сообщества бота.

## Оглавление
* [Установка и Подключение](#Установка)

## Установка
1) Скачиваем файлы
2) Перекидываем их в одну папку и выдаем права 777 на все файлы.
3) Настраиваем bot.php, events это список того на что будет отвечать бот, например юзера кикнули или он сам ушел и будет происходить действие. Токен, думаю и так все знают что это такое.
```php 
require("lib/Zero.php");

$token = ''; //Токен Сообщества

//Список эвентов таких как получения сообщения, отписка и подписка и тд.

$events = [
    'message_new' => function($object, $Zero){
        global $cmds;
        foreach ($cmds as $cmd){
            if(preg_match_all($cmd['r'], $object['text'], $params, PREG_SET_ORDER)){
                $cmd['f']($Zero, $Zero->user(), $params[0]);
            }
        }
    }
];

$Zero = new Zero($token);
$Zero->longpoll->init();
```
4) Папка cmds, в ней один файл: Test.php. Их можно самим создавать, они автоматически будут подключатся, и добавляем команду по шаблону.
```php
CommandManager::addCommand('/^kek$/iu', function ($Zero, $user, $params){
    $Zero->reply($user['first_name'].", Cheburek");
});
```
5) Запускаем: Переходим в директорию с ботом и пишем php bot.php
