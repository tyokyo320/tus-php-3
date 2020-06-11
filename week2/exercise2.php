<?php

// SESSION 起動
session_start();

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

// テスト開始時の処理
function kaishi(){
    $_SESSION["IR"] = array(
        // 項目数
        "N" => 0,
        // 問題履歴
        "I" => [0],
        // 反応履歴
        "X" => [],
        // 能力値
        "T" => 0
    );
    return questions(0);
}

// テスト接続時の処理
function keizoku($choice){
    // 現在の問題番号を取得
    $i = $_SESSION["IR"]["I"][$_SESSION["IR"]["N"]];
    $item = questions($i);
    $_SESSION["IR"]["X"][] = ($choice == $item["correct"]) ? 1 : 0;
    $_SESSION["IR"]["N"]++;
    $_SESSION["IR"]["T"] = array_sum($_SESSION["IR"]["X"]) / $_SESSION["IR"]["N"];
    $item = questions($i + 1);
    $_SESSION["IR"]["I"][] = $item["id"];

    return $item;
}

// テスト終了時の処理
function owari(){
    echo "試験が終了です. ";
    echo "あなたの能力値は" . $_SESSION["IR"]["T"] . "です";
    unset($_SESSION["IR"]);
    exit;
}

function main(){
    if (isset($_SESSION["IR"]) && isset($_POST["choices"])) {
        $item = keizoku($_POST["choices"]);
    }
    else
        $item = kaishi();
    if ($item === false || $_SESSION["IR"]["N"] >= 2) {
        $item = owari;
    }
    return $item;
}

var_dump(main());