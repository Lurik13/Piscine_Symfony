<?php
    $input = file_get_contents('ex01.txt');
    for ($i = 0; $i < strlen($input); $i++)
    {
        if ($input[$i] == ',')
            echo "\n";
        else
            echo $input[$i];
    }
    echo "\n";
?>