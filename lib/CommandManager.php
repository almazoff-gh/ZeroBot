<?php
class CommandManager{
    function __construct(){
        global $count;
        $count = 0;
        notify("Подключен CommandManager");
    }
    function start(){
        $files = glob("cmds/*.php");
        foreach ($files as $number => $file){
            require($file);
        }
    }
    function addCommand($r, $f){
        global $cmds, $count;
        $count++;
        $cmds[] = [
            'r' => $r,
            'f' => $f
        ];
    }
}