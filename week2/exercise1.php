<?php

function questions($i)
{
    $content = file_get_contents("ItemBank.json");
    $itemBank = json_decode($content, true);
    if (isset($itemBank[$i])) {
        return $itemBank[$i];
    } else {
        return false;
    }
}

var_dump(questions(0));