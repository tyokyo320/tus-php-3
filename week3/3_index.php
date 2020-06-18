<?php
require_once("1_functions.php");
require_once("3_functions.php");
$item = main();
?>

<html>
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    <script src="3_interface.js"></script>
    <script>
        window.onload = function(){
            var item = <?php echo json_encode($item); ?>;
            kaitouSeisei(item);
            questionnaire(item);
        }
    </script>
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
            font-size: 25px;
            font-weight: 900;
        }

        .question {
            padding: 20px;
            font-size: 25px;
            font-weight: 900;
        }

        .choices {
            padding: 30px;
            font-size: 25px;
        }

        .questionnaire {
            padding: 30px;
            font-size: 25px;
            vertical-align: middle;
            margin: 0px;
        }

        .panel-default {
            padding: 20px;
            font-size: 25px;
            font-weight: 900;
        }


        #page-center {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        body{
            background-image: url('https://blog.tyokyo320.com/images/background.png');
            background-size: cover;
            padding-top: 200px;
       
        }

        p {
            font-size: 35px;
            font-weight: 900;
        }
    </style>
    <script type="text/javascript">
        var n_timer = timer();
        // 计算学生的做题时间
        var n_sec = 0; //秒
        var n_min = 0; //分
        var n_hour = 0; //时

        // 60秒 === 1分
        // 60分 === 1小时
        function timer() {
            return setInterval(function () {
                var str_sec = n_sec;
                var str_min = n_min;
                var str_hour = n_hour;
                if (n_sec < 10) {
                    str_sec = "0" + n_sec;
                }
                if (n_min < 10) {
                    str_min = "0" + n_min;
                }
                if (n_hour < 10) {
                    str_hour = "0" + n_hour;
                }

                var time = str_hour + ":" + str_min + ":" + str_sec;
                var ele_timer = document.getElementById("timer");
                ele_timer.value = time;
                // console.log(ele_timer.value);
                n_sec++;

                if (n_sec > 59) {
                    n_sec = 0;
                    n_min++;
                }
                if (n_min > 59) {
                    n_min = 0;
                    n_hour++;
                }
            }, 1000);
        }
    </script>
</head>

<body>
    <div id="page-center">
        <form method="post" class="container">
            <span class="index"><?php
            echo "問題". questions_number()
            ?></span>
            <div class="jumbotron" id="question"></div>
            <div class="choices" id="choices"></div>
            <div style="padding: 30px;">
                <button class="btn btn-secondary" id="answer" type="submit">解答</button>
            </div>
            <div class="questionnaire" id="questionnaire"></div>

            <div class="panel panel-default">
                <label>解答時間: </label><input type="text" name="timer" readonly="readonly" id="timer" style="border: none;">
            </div>
        </from>
    </div>
</body>

</html>

