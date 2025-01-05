<?php
    $states = [
    'Oregon' => 'OR',
    'Alabama' => 'AL',
    'New Jersey' => 'NJ',
    'Colorado' => 'CO',
    ];
    $capitals = [
    'OR' => 'Salem',
    'AL' => 'Montgomery',
    'NJ' => 'trenton',
    'KS' => 'Topeka',
    ];

    function is_state($loc)
    {
        global $states, $capitals;
        if (array_key_exists($loc, $states) &&
            array_key_exists($states[$loc], $capitals))
        {
            echo $capitals[$states[$loc]] . " is the capital of $loc.\n";
            return (true);
        }
        return (false);
    }

    function is_capital($found, $loc)
    {
        global $states, $capitals;
        if ($found == false && in_array($loc, $capitals))
        {
            foreach ($capitals as $capital_key => $capital_value)
            {
                if ($capital_value == $loc && in_array($capital_key, $states))
                {
                    foreach ($states as $state_key => $state_value)
                    {
                        if ($state_value == $capital_key)
                        {
                            echo "$loc is the capital of $state_key.\n";
                            return (true);
                        }
                    }
                    break ;
                }
            }
        }
        return ($found);
    }

    // function search_by_states("Oregon, trenton, Topeka, NewJersey")
    function search_by_states($locations_string)
    {
        $locations = explode(", ", $locations_string);
        foreach ($locations as $loc)
        {
            $found = is_state($loc);
            $found = is_capital($found, $loc);
            if ($found == false)
                echo "$loc is neither a capital nor a state.\n";
        }
    }
?>
