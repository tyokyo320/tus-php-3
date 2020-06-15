<?php

// SESSION 起動
session_start();

function questions($i)
{
    $itemBank = json_decode(file_get_contents("ItemBank.json"), true);
    if (isset($itemBank[$i])) {
        return $itemBank[$i];
    } else {
        return false;
    }
}

// テスト開始時の処理
function kaishi(){
    // init
    $_SESSION["IR"] = array(
        // 項目数
        "N" => 0,
        // 問題履歴
        "I" => [0],
        // 反応履歴
        "X" => [],
        // 能力値
        "T" => 0,
        // 問題履歴
        "H" => []
    );
    return questions(0);
}

// テスト接続時の処理
function keizoku($choice){
    // 获取当前正在回答的问题号
    $i = $_SESSION["IR"]["I"][$_SESSION["IR"]["N"]];
    // 获取当前问题
    $item = questions($i);
    // 记录所选的答案
    $_SESSION["IR"]["H"][] = $choice;
    // 判断对错，并记录结果
    $_SESSION["IR"]["X"][] = ($choice == $item["correct"]) ? 1 : 0;
    // 已做题目数量+1
    $_SESSION["IR"]["N"]++;
    // 能力值
    $_SESSION["IR"]["T"] = array_sum($_SESSION["IR"]["X"]) / $_SESSION["IR"]["N"];
    // 获取下一道题
    $item = questions($i + 1);
    // 记录答题id
    $_SESSION["IR"]["I"][] = $item["id"];
    return $item;
}

function questions_number(){
    return $_SESSION["IR"]["I"][$_SESSION["IR"]["N"]] + 1;
}

// テスト終了時の処理
function owari(){
    echo "<h1>試験が終了です</h1>";
    echo "<h1>あなたの能力値は" . $_SESSION["IR"]["T"] . "です</h1>";

    $convert = array(
        1 => "A",
        2 => "B",
        3 => "C",
        4 => "D",
    );

    $content_table =<<< CONTENT_TABLE
    <style> 
        .table-1 {
            width: 500px;
            background: #acb6e5;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #86fde8, #acb6e5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #86fde8, #acb6e5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */;
        }
    </style>
    <div class="table-1">
    <table border="1"， width="500">
        <tr>
            <th>ID</th>
            <th>解答</th>
        </tr>
    CONTENT_TABLE;
    echo $content_table;

    foreach ($_SESSION["IR"]["H"] as $key => $value) {
        $content_body =<<< CONTENT_BODY
        <tr>
            <td>$key</td>
            <td>$convert[$value]</td>
        </tr>
        CONTENT_BODY;
        echo $content_body;
    }
        
    // var_dump($_SESSION["IR"]["H"]);
    unset($_SESSION["IR"]);
    exit;
}

function main(){
    # 如果设置了IR键，同时是POST提交且提交里面有choices
    if (isset($_SESSION["IR"]) && isset($_POST["choices"])) {
        # 回答当前问题且返回下一道题
        $item = keizoku($_POST["choices"]);

    }
    # 否则初始化
    else {
        $item = kaishi();
    }

    if ($item === false || $_SESSION["IR"]["N"] >= 5) {
         owari();
    }
                                                                                                                                                                                                                                                                                                                                                                                                   
    return $item;
}


// var_dump(questions(0));
// var_dump(main());
