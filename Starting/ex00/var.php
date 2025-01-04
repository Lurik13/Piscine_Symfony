<?php 
    $letters = array(
        "a" => 10,
        "b" => "10",
        "c" => "ten",
        "d" => 10.0
    );

    echo "\e[38;2;170;50;170;1mMy first variables:\n\e[0m";
    foreach ($letters as $key => $value)
        echo "$key contains : $value and has type : " . gettype($value) . "\n";
?>