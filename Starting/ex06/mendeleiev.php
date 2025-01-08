<?php 
    /* *************************************************************** */
    /* *************************** BACKEND *************************** */
    /* *************************************************************** */

    class Element
    {
        public $name;
        public $position;
        public $number;
        public $small;
        public $molar;
        public $electron;
        public int $nb_electrons;

        public function __construct($line)
        {
            $categories = explode(", ", $line);
            $this->name = strtok($line, " ");
            $this->position = extractAfterColon($categories[0]);
            $this->number = extractAfterColon($categories[1]);
            $this->small = extractAfterColon($categories[2]);
            $this->molar = extractAfterColon($categories[3]);
            $this->electron = extractAfterColon($categories[4]);
            $this->nb_electrons = 0;
            $tok = strtok($this->electron," ");
            while ($tok)
            {
                $this->nb_electrons += intval($tok);
                $tok = strtok(" ");
            }
        }
    }

    function extractAfterColon($line)
    {
        $parts = explode(':', $line);
        return trim($parts[1]);
    } 

    function fill_elements_array($file)
    {
        $line = fgets($file);
        $elements = array();
        while ($line)
        {
            $new_elem = new Element($line);
            array_push($elements, $new_elem);
            $line = fgets($file);
        }
        return $elements;
    }



    /* *************************************************************** */
    /* ************************** FRONTEND *************************** */
    /* *************************************************************** */

    function head($html)
    {
        fwrite($html, "
<!DOCTYPE html>
<html>
    <head>
        <title>Mendeleiev</title>
        <meta charset=\"UTF-8\">
        <style>
            td {
                border: 1px solid black;
                padding: 10px;
            }
            .void {
                border: 0px;
            }
        </style>
    </head>");
    }

    function skip_empty_slots($html, $element, $i)
    {
        if ($element->position == 0)
        {
            $i = 0;
            fwrite($html, "
            <tr>");
        }
        while ($element->position != $i)
        {
            fwrite($html, "
                <td class=\"void\"></td>");
            $i++;
        }
        return ++$i;
    }

    function color_full_cells($html, $element)
    {
        fwrite($html, "
                <td style=\"background-color:");
        if ($element->position == 0 && $element->number != 1)
            fwrite($html, "#224354\">");
        elseif ($element->position == 1)
            fwrite($html, "#4b372e\">");
        elseif ($element->position == 17)
            fwrite($html, "#3f3370\">");
        elseif ($element->position >= 2 && $element->position <= 11 && ($element->number < 109 || $element->number > 117))
            fwrite($html, "#2c4425\">");
        elseif ($element->number >= 109 && $element->number <= 117)
            fwrite($html, "#46474c\">");
        elseif (in_array($element->number, [5, 14, 32, 33, 51, 52]))
            fwrite($html, "#612339\">");
        elseif (in_array($element->number, [13, 31, 49, 50, 81, 82, 83, 84, 85]))
            fwrite($html, "#664915\">");
        else
            fwrite($html, "#6b2b00\">");
    }

    function write_in_cells($html, $element)
    {
        fwrite($html, "
                    <h4>$element->name</h4>
                    <ul>
                        <li>Nb $element->number</li>
                        <li>$element->small</li>
                        <li>$element->molar</li>
                        <li>$element->nb_electrons electron"); 
        if ($element->nb_electrons > 1)
            fwrite($html, "s");
        fwrite($html, "
                        </li>
                    </ul>
                </td>");
    }

    function body($html, $elements)
    {
        fwrite($html, "
    <body style=\"background-color:#1e1f22;\">
        <table style=\"color:white\">");
        $i = 0;
        foreach ($elements as $element)
        {
            $i = skip_empty_slots($html, $element, $i);
            color_full_cells($html, $element);
            write_in_cells($html, $element);
        }
        fwrite($html,"
        </table>
    </body>
</html>");
    }



    /* *************************************************************** */
    /* ***************************** MAIN **************************** */
    /* *************************************************************** */
    
    function mendeleiev()
    {
        $file = fopen("ex06.txt","r");
        $elements = fill_elements_array($file);
        fclose($file);

        if (file_exists("mendeleiev.html"))
            unlink('mendeleiev.html');
        $html = fopen("mendeleiev.html", "a");
        head($html);
        body($html, $elements);
        fclose($html);
    }

    mendeleiev();
?>
