<?php

function practice1(){
    $start = -3.0;
    $end = 3.0;
    $step = 1.0;
    foreach (range($start, $end, $step) as $theta)
        print($theta . ", ");
}

// 確率密度
function seiki($theta){
    return exp(-pow($theta, 2) / 2) / sqrt(2 * M_PI);
}

// 標準正規分布
function seikiBunpu($start, $end, $step){
    $dist = [];
    foreach (range($start, $end, $step) as $theta)
    $dist[] = seiki($theta) * $step;
    return $dist;
}

// 受験者が問題に正答する確率
function seitouKakuritsu($theta, $a, $b){
    return 1.0 / (1.0 + exp(-1.7 * $a * ($theta - $b)));
}

// 正答・誤答に対応した反応確率
function hannouKakuritsu($x, $theta, $a, $b){
    $p = seitouKakuritsu($theta, $a, $b);
    return pow($p, $x) * pow(1.0 - $p, 1 - $x);
}

// 項目特性曲線の配列
function icc($x, $a, $b, $start, $end, $step){
    $iccDist = [];
    foreach (range($start, $end, $step) as $theta) {
        $iccDist[] = hannouKakuritsu($x, $theta, $a, $b);
    }
    return $iccDist;
}

// ベイズ推定に基づき反応確率分布
function bayes($x, $itemBank, $start, $end, $step){
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
    // 周辺尤度の計算
    $shuhen = array_sum($dist);
    for ($t = 0; $t < $length; $t++) {
        $dist[$t] /= $shuhen;
    }
    return $dist;
}

// 配列の最大値の添字
function argmax($v){
    return array_search(max($v), $v);
}

// 能力値の推定結果
function estimation($x, $itemBank, $start, $end, $step){
    $probability = bayes($x, $itemBank, $start, $end, $step);
    $thetaDist = range($start, $end, $step);
    $theta = $thetaDist[argmax($probability)];
    return $theta;
}

// 項目情報量
function information($theta, $itemBank){
    $info = 0.0;
    foreach ($itemBank as $item) {
        $p = seitouKakuritsu($theta, $item["a"], $item["b"]);
        $info += 1.7 * 1.7 * $item["a"] * $item["a"] * $p * (1 - $p);
    }
    return $info;
}

// 標準誤差
function error($theta, $itemBank){
    return 1.0 / sqrt(information($theta, $itemBank));
}

// 能力値推定精度のシミュレーション
function simulation($N, $J){
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

print("平均誤差:" . simulation(50, 100));

// practice1();
// var_dump(practice1());
// var_dump(seikiBunpu(-3, 3, 1));

// var_dump(hannouKakuritsu(1, 0, 1, 0));
// var_dump(icc(1, 1, 0, -3, 3, 1));

// var_dump(bayes([1], [array("a" => 1, "b" => 0)], -2, 2, 1));
// var_dump(estimation([1], [array("a" => 1, "b" => 0)], -2, 2, 1));

// var_dump(information(0, [array("a" => 1, "b" => 0)]));