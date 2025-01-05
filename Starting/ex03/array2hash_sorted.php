<?php
    function array2hash_sorted($array)
    {
        $hash = array();
        foreach($array as $elem)
            $hash[$elem[0]] = $elem[1];
        krsort($hash);
        return ($hash);
    }
?>
