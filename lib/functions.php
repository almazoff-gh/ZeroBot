<?php
function notify($text){
    console(
        Colors::magenta_bold('(DEBUG)'),
        Colors::green_bold(date('[Y-m-d H:i:s] ', time())),
        Colors::white_bold($text)
    );
}