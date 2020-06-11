<?php
require_once("2_functions.php");
$item = main();
?>

<html>
<head>
    <meta charset="UTF-8">
    <script src="2_interface.js"></script>
    <script>
        window.onload = function(){
            var item = <?php echo json_encode($item); ?>;
            kaitouSeisei(item);
        }
    </script>
</head>

<body>
<form method="post">
    <div id="question"></div>
    <div id="choices"></div>
    <button id="answer" type="submit">解答</button>
</from>
</body>

</html>