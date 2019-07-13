<?php
CommandManager::addCommand('/^Test$/iu', function ($Zero, $user, $params){
    $Zero->reply($user['first_name'].", OK");
});