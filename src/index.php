<?php

require_once('vendor/autoload.php');

$stringCalculator = new StringCalculator();

try {
    echo $stringCalculator->add('//$,@,*\n1$2@3*8*8');
}catch (Exception $ex) {
    echo $ex->getMessage();
}
