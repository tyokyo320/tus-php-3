<?php
require_once("option_functions.php");
info_main();
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

        <style>
        .questionnaire {
            padding: 20px;
            font-size: 25px;
            vertical-align: middle;
            margin: 0px;
        }

        #page-center {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        body{
            background-image: url('https://file02.16sucai.com/d/file/2014/0512/de4c07d161af73cb200ebcf2bd26ad01.jpg');
            background-size: cover;
            padding-top: 200px;
       
        }

        p {
            font-size: 35px;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <div id="page-center">
        <form action="option_index.php" method="post" class="container">
            <p name="info_question1" class="jumbotron">「英語」に対する自信度は？</p>
            <input style="display: none;" type="text" name="info_question1"" value="「英語」に対する自信度は？">
            <div class="choices" id="questionnaire">
                <div><input required="" type="radio" name="info_answer1"" value="1"><label>自信なし</label></div>
                <div><input required="" type="radio" name="info_answer1" value="2"><label>やや自信なし</label></div>
                <div><input required="" type="radio" name="info_answer1" value="3"><label>やや自信あり</label></div>
                <div><input required="" type="radio" name="info_answer1" value="4"><label>自信あり</label></div>
            </div>
            <p name="info_question2" class="jumbotron">「数学」に対する自信度は？</p>
            <input style="display: none;" type="text" name="info_question2"" value="「数学」に対する自信度は？">
            <div class="choices" id="questionnaire">
                <div><input required="" type="radio" name="info_answer2" value="1"><label>自信なし</label></div>
                <div><input required="" type="radio" name="info_answer2" value="2"><label>やや自信なし</label></div>
                <div><input required="" type="radio" name="info_answer2" value="3"><label>やや自信あり</label></div>
                <div><input required="" type="radio" name="info_answer2" value="4"><label>自信あり</label></div>
            </div>
            <button class="btn btn-secondary" id="answer" type="submit">解答</button>
        </form>
    </div>
</body>

</html>