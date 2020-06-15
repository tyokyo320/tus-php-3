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
        "H" => [],
        // 自信度履歴
        "Q" => [],
        // 時間
        "time" => []
    );
    return questions(0);
}

// info.php開始時の処理
function kaishi1(){
    // init
    $_SESSION["INFO"] = array(
        // 冒頭問題
        "info_question" => [],
        // 冒頭履歴
        "info_answer" => []
    );
}

// テスト接続時の処理
function keizoku($choice){
    // 自信度調査
    $questionnaire = $_POST["questionnaire"];
    // 自信度記録
    $_SESSION["IR"]["Q"][] = $questionnaire;
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
    // 解答時間を記録する
    if (strlen($_POST["timer"]) == 0) {
        $_SESSION["IR"]["time"][] = '00:00:01';        
    } else {
        $_SESSION["IR"]["time"][] = $_POST["timer"];
    }
    return $item;
}

// info.phpで使う
function keizoku1(){
    $_SESSION["INFO"]["info_question"][] = $_POST["info_question1"];
    $_SESSION["INFO"]["info_question"][] = $_POST["info_question2"];
    $_SESSION["INFO"]["info_answer"][] = $_POST["info_answer1"];
    $_SESSION["INFO"]["info_answer"][] = $_POST["info_answer2"];
}

function questions_number(){
    return $_SESSION["IR"]["I"][$_SESSION["IR"]["N"]] + 1;
}

// テスト終了時の処理
function owari(){
    echo "<body>";
    $body =<<< BODY
    <style>
        body{
            background-image: url('https://blog.tyokyo320.com/images/background.png');
            background-size: cover;
            text-align: center;
            padding: 200px;
        }
    </style>
    BODY;
    echo $body;
    echo "<h1>試験が終了です</h1>";
    echo "<h1>あなたの能力値は" . $_SESSION["IR"]["T"] . "です</h1>";
    echo "<h1>あなたの誤謬率は" . (1 - $_SESSION["IR"]["T"]) . "です</h1>";

    // 解答欄にアルファベット表示に変更
    $convert = array(
        1 => "A",
        2 => "B",
        3 => "C",
        4 => "D",
        "分からない" => "分からない"
    );

    // 自信度欄にアルファベット表示に変更
    $convert_questionnaire = array(
        1 => "自信なし",
        2 => "やや自信なし",
        3 => "やや自信あり",
        4 => "自信あり",
    );

    // 表のheader
    $content_table =<<< CONTENT_TABLE
    <style> 
        .table-1 {
            width: 500px;
            margin: 0 auto;
            background: #acb6e5;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #86fde8, #acb6e5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #86fde8, #acb6e5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */;
        }
        td {
            text-align:center;
        }
    </style>
    <div class="table-1">
    <table border="1" width="500">
        <tr>
            <th>ID</th>
            <th>解答</th>
            <th>自信度</th>
            <th>解答時間</th>
        </tr>
    CONTENT_TABLE;
    echo $content_table;

    for ($i = 0; $i < count($_SESSION["IR"]["H"]); $i++) {
        $value = $_SESSION["IR"]["H"][$i];
        $questionnaire_value = $_SESSION["IR"]["Q"][$i];
        $time = $_SESSION["IR"]["time"];

        $content_body =<<< CONTENT_BODY
        <tr>
            <td>$i</td>
            <td>$convert[$value]</td>
            <td>$convert_questionnaire[$questionnaire_value]</td>
            <td>$time[$i]</td>
        </tr>
        CONTENT_BODY;
        echo $content_body;
    }
    echo "</table>";
    echo "</div>";

    $info_table =<<< INFO_TABLE
    <style> 
        .table-2 {
            width: 500px;
            margin: 0 auto;
            margin-top: 2cm;
            background: #83a4d4;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #b6fbff, #83a4d4);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #b6fbff, #83a4d4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */;
        }
        td {
            text-align:center;
        }
    </style>
    <div class="table-2">
    <table border="1"， width="500">
        <tr>
            <th>冒頭の自信度問題</th>
            <th>解答</th>
        </tr>
    INFO_TABLE;
    echo $info_table;

    for ($i = 0; $i < count($_SESSION["INFO"]["info_question"]); $i++) { 
        $info_question = $_SESSION["INFO"]["info_question"][$i];
        $info_answer = $_SESSION["INFO"]["info_answer"][$i];

        $info_body =<<< INFO_BODY
        <tr>
            <td>$info_question</td>
            <td>$convert_questionnaire[$info_answer]</td>
        </tr>
        INFO_BODY;
        echo $info_body;
    }
    echo "</table>";
    echo "</div>";
    echo "</body>";


    unset($_SESSION["IR"]);
    unset($_SESSION["INFO"]);
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
                                                                                                                                                                                                                                                                                                                                                                                                   
    if (isset($_SESSION["INFO"]) && isset($_POST["info_answer1"]) && isset($_POST["info_answer2"])) {
        keizoku1();
    }

    return $item;
}

function info_main(){
    kaishi1();
}