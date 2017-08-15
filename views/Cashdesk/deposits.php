<?php
    $date = date("d.m.Y");
    $deposits = getDepositsAmount($date);
    $class = "";
    $arrDeposits = getDeposits($date);
    if(!$arrDeposits){
        $depositsText =  "нет залогов";
        $class ="hidden";
    }
    else {
        if (substr($deposits[0], -1) == '1') {
            $depositsText = "залог";
        } elseif (substr($deposits[0], -1) > 1 && substr($deposits[0], -1) < 5) {
            $depositsText = "залога";
        } else {
            $depositsText = "залогов";
        }
        $depositsText = "{$deposits[0]} $depositsText, на сумму {$deposits[1]} рублей";
    }
    require_once TEMPLATES . "/deposits.php";

?>