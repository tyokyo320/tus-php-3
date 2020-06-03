<?php

function practice1()
{
    $start = -3.0;
    $end = 3.0;
    $step = 1.0;
    foreach (range($start, $end, $step) as $theta)
        print(seiki($theta) . ", ");
}

function seiki($theta)
{
    return exp(-pow($theta, 2) / 2) / sqrt(2 * M_PI);
}

function seikiBunpu($start, $end, $step)
{
    $dist = [];
    foreach (range($start, $end, $step) as $theta)
        $dist[] = seiki($theta) * $step;
    return $dist;
}

function seitouKakuritsu($theta, $a, $b)
{
    return 1.0 / (1.0 + exp(-1.7 * $a * ($theta - $b)));
}

function hannouKakuritsu($x, $theta, $a, $b)
{
    $p = seitouKakuritsu($theta, $a, $b);
    return pow($p, $x) * pow(1.0 - $p, 1 - $x);
}

function icc($x, $a, $b, $start, $end, $step)
{
    $iccDist = [];
    foreach (range($start, $end, $step) as $theta) {
        $iccDist[] = hannouKakuritsu($x, $theta, $a, $b);
    }
    return $iccDist;
}

function old_bayes($x, $itemBank, $start, $end, $step)
{
    $n = count($x);
    $thetaDist = range($start, $end, $step);
    $length = count($thetaDist);

    $dist = seikiBunpu($start, $end, $step);
    for ($i = 0; $i < $n; $i++) {
        $item = $itemBank[$i];
        $yuudoDist = icc($x[$i], $item["a"], $item["b"], $start, $end, $step);
        for ($t = 0; $t < $length; $t++) {
            $dist[$t] *= $yuudoDist[$t];
        }
    }

    $shuhen = array_sum($dist);
    for ($t = 0; $t < $length; $t++) {
        $dist[$t] /= $shuhen;
    }
    return $dist;
}

function bayes($x, $itemBank, $start, $end, $step)
{
    $n = count($x);
    $thetaDist = range($start, $end, $step);
    $length = count($thetaDist);

    $dist = seikiBunpu($start, $end, $step);
    for ($i = 0; $i < $n; $i++) {
        $item = $itemBank[$i];
        $yuudoDist = icc($x[$i], $item["a"], $item["b"], $start, $end, $step);
        for ($t = 0; $t < $length; $t++) {
            $dist[$t] += log($yuudoDist[$t]);
        }
    }

    $shuhen = array_sum($dist);
    for ($t = 0; $t < $length; $t++) {
        $dist[$t] -= $shuhen;
    }
    return $dist;
}

function argmax($v)
{
    return array_search(max($v), $v);
}

function estimation($x, $itemBank, $start, $end, $step)
{
    $probability = bayes($x, $itemBank, $start, $end, $step);
    //$probability = old_bayes($x, $itemBank, $start, $end, $step);
    $thetaDist = range($start, $end, $step);
    $theta = $thetaDist[argmax($probability)];
    return $theta;
}

function information($theta, $itemBank)
{
    $info = 0.0;
    foreach ($itemBank as $item) {
        $p = seitouKakuritsu($theta, $item["a"], $item["b"]);
        $info += 1.7 * 1.7 * $item["a"] * $item["a"] * $p * (1 - $p);
    }
    return $info;
}

function error($theta, $itemBank)
{
    return 1.0 / sqrt(information($theta, $itemBank));
}

function  testInformation($itemBank,  $start,  $end,  $step)
{
    $thetaDist = range($start,  $end,  $step);
    $infoDist = array_pad([], count($thetaDist), 0);
    for ($t = 0; $t < count($thetaDist); $t++)
        $infoDist[$t] = information($thetaDist[$t], $itemBank);
    return $infoDist;
}

function tekiouTest($theta, $itemBank)
{
    $infoDist = [];
    foreach ($itemBank as $item)
        $infoDist[] =  information($theta,  [array("a" => $item["a"], "b" => $item["b"])]);
    return argmax($infoDist);
}

function simulation($N, $J)
{
    $itemBank = [];
    for ($i =  0; $i <  $N; $i++)
        $itemBank[] = array(
            "a" => rand(1, 200) / 100,
            "b" => rand(-300, 300) / 100,
        );

    $examinee = [];
    for ($j = 0; $j < $J; $j++)
        $examinee[] = rand(-300, 300) / 100;

    $error = [];
    foreach ($examinee as $theta) {
        $x = [];
        foreach ($itemBank as $test)
            $x[] = seitouKakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
    }
    return array_sum($error) / count($examinee);
}

function weibull($m, $eta)
{
    return $eta * pow((-log(1 - rand(0, 99) / 100)), 1 / $m);
}


var_dump(practice1());
var_dump(seikiBunpu(-3, 3, 1));
var_dump(hannouKakuritsu(1, 0, 1, 0));
var_dump(icc(1, 1, 0, -3, 3, 1));
var_dump(bayes([1], [array("a" => 1, "b" => 0)], -2, 2, 1));
var_dump(estimation([1], [array("a" => 1, "b" => 0)], -2, 2, 1));
var_dump(information(0, [array("a" => 1, "b" => 0)]));
print("平均誤差：" . simulation(50, 100));

// quiz num
$f = fopen("quiz_number.txt", "w");
for ($i = 1; $i <= 100; $i++) {
    $result = [];
    for ($j = 0; $j < 10; $j++) {
        $result[] = simulation($i, 100);
    }
    fwrite($f, $i . " " . array_sum($result) / count($result) . "\n");
}
fclose($f);

// people num
$f = fopen("people_number.txt", "w");
for ($i = 1; $i <= 100; $i++) {
    $result = [];
    for ($j = 0; $j < 10; $j++) {
        $result[] = simulation(50, $i);
    }
    fwrite($f, $i . " " . array_sum($result) / count($result) . "\n");
}
fclose($f);

// new bayes
$f = fopen("new_bayes.txt", "w");
for ($i = 1; $i <= 10; $i++) {
    $result = [];
    for ($j = 0; $j < $i; $j++) {
        $result[] = simulation(50, 100);
    }
    fwrite($f, $i . " " . simulation(50, 100) . "\n");
}
fclose($f);

// old bayes
$f = fopen("old_bayes.txt", "w");
for ($i = 1; $i <= 10; $i++) {
    $result = [];
    for ($j = 0; $j < $i; $j++) {
        $result[] = simulation(50, 100);
    }
    fwrite($f, $i . " " . simulation(50, 100) . "\n");
}
fclose($f);

function kadai_simulation($N, $J)
{
    $itemBank = [];
    for ($i =  0; $i <  $N; $i++)
        $itemBank[] = array(
            "a" => weibull(2, 100) / 100,
            "b" => rand(-300, 300) / 100,
        );

    $examinee = [];
    for ($j = 0; $j < $J; $j++)
        $examinee[] = rand(-300, 300) / 100;

    $error = [];
    foreach ($examinee as $theta) {
        $x = [];
        foreach ($itemBank as $test)
            $x[] = seitouKakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
    }
    return array_sum($error) / count($examinee);
}

// quiz num
$f = fopen("kadai_quiz_number_100.txt", "w");
for ($i = 1; $i <= 100; $i++) {
    $result = [];
    for ($j = 0; $j < 10; $j++) {
        $result[] = kadai_simulation($i, 100);
    }
    fwrite($f, $i . " " . array_sum($result) / count($result) . "\n");
}
fclose($f);