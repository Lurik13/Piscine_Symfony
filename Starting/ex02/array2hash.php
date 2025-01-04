<?php
    function array2hash($array)
    {
        $hash = array();
        foreach($array as $elem)
            $hash[$elem[1]] = $elem[0];
        return ($hash);
    }
?>