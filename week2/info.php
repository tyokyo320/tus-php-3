<?php
require_once("2_functions.php");
info_main();
?>

<html>
<head>
    <meta charset="UTF-8">
        <style>
        .button {
            display: inline-block;
            padding: 10px 25px;
            margin: 20px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;   
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }

        .button:hover {background-color: #3e8e41}

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px); 
        }

        .index {
            padding: 20px;
        }

        .question {
            padding: 20px;
        }

        .choices {
            padding: 20px;
        }

        .questionnaire {
            padding: 20px;
        }

        .panel-default {
            padding: 20px;
        }

        body{
            background-image: url('https://blog.tyokyo320.com/images/background.png');
            background-size: cover;
            text-align: center;
            padding: 200px;
        }

        p {
            font-size: 35px;
            font-weight: 900;
        }

    </style>
</head>

<body>
    <div style="width:100%; text-align:center">
        <form action="2_index.php" method="post">
            <p name="info_question1">「英語」に対する自信度は？</p>
            <input style="display: none;" type="text" name="info_question1"" value="「英語」に対する自信度は？">
            <div class="questionnaire" id="questionnaire">
                <div><input required="" type="radio" name="info_answer1"" value="1"><label>自信なし</label></div>
                <div><input required="" type="radio" name="info_answer1" value="2"><label>やや自信なし</label></div>
                <div><input required="" type="radio" name="info_answer1" value="3"><label>やや自信あり</label></div>
                <div><input required="" type="radio" name="info_answer1" value="4"><label>自信あり</label></div>
            </div>
            <p name="info_question2">「数学」に対する自信度は？</p>
            <input style="display: none;" type="text" name="info_question2"" value="「数学」に対する自信度は？">
            <div class="questionnaire" id="questionnaire">
                <div><input required="" type="radio" name="info_answer2" value="1"><label>自信なし</label></div>
                <div><input required="" type="radio" name="info_answer2" value="2"><label>やや自信なし</label></div>
                <div><input required="" type="radio" name="info_answer2" value="3"><label>やや自信あり</label></div>
                <div><input required="" type="radio" name="info_answer2" value="4"><label>自信あり</label></div>
            </div>
            <button class="button" id="answer" type="submit">解答</button>
        </form>
    </div>
</body>

</html>