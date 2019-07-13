<?php
CommandManager::addCommand('/^Test$/iu', function ($Zero, $user, $params){
    $Zero->send($user['first_name'].', OK');
});