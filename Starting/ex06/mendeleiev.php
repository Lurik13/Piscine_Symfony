<?php 
    class Element
    {
        public $name;
        public $position;
        public $number;
        public $small;
        public $molar;
        public $electron;
        public int $nb_electrons;

        public function __init($line)
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
        $parts = explode(':', $line, 2);
        return trim($parts[1]);
    } 

    function fill_elements_array($file)
    {
        $line = fgets($file);
        $elements = array();
        while ($line)
        {
            $new_elem = new Element;
            $new_elem->__init($line);
            array_push($elements, $new_elem);
            $line = fgets($file);
        }
        // var_dump($elements);
        return $elements;
    }

    $file = fopen("ex06.txt","r");
    $elements = fill_elements_array($file);
    fclose($file);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mendeleiev</title>
        <meta charset="UTF-8">
        <style>
            td {
                border: 1px solid black;
                padding: 10px;
            }
            .void {
                border: 0px;
            }
        </style>
    </head>
    <body style="background-color:#1e1f22;">
        <table style="color:white">
            <!-- Skip toutes les cases vides -->
            <?php $i = 0; ?>
            <?php foreach ($elements as $element): ?>
                <?php if ($element->position == 0): ?>
                    <?php $i = 0 ?>
                    <tr>
                <?php endif; ?>
                <?php while ($element->position != $i):?>
                    <td class="void"></td>
                    <?php $i++ ?>
                <?php endwhile;?>
                <?php $i++ ?>

                <!-- Pour les cases pleines -->
                <?php if ($element->position == 0 && $element->number != 1): ?> 
                    <td style="background-color:#224354">
                <?php elseif ($element->position == 1): ?> 
                    <td style="background-color:#4b372e">
                <?php elseif ($element->position == 17): ?> 
                    <td style="background-color:#3f3370">
                <?php elseif ($element->position >= 2 && $element->position <= 11 && ($element->number < 109 || $element->number > 117)): ?> 
                    <td style="background-color:#2c4425">
                <?php elseif ($element->number >= 109 && $element->number <= 117): ?> 
                    <td style="background-color:#46474c">
                <?php elseif (in_array($element->number, [5, 14, 32, 33, 51, 52])): ?> 
                    <td style="background-color:#612339">
                <?php elseif (in_array($element->number, [13, 31, 49, 50, 81, 82, 83, 84, 85])): ?> 
                    <td style="background-color:#664915">
                <?php else : ?>
                    <td style="background-color:#6b2b00">
                <?php endif; ?> 
                    <h4><?php echo $element->name ?></h4>
                    <ul>
                        <li>Nb <?php echo $element->number ?></li>
                        <li><?php echo $element->small ?></li>
                        <li> <?php echo $element->molar ?> </li>
                        <li><?php echo $element->nb_electrons ?> electron<?php 
                            if ($element->nb_electrons > 1): echo 's'; endif?></li>
                    </ul>
                </td>
            <?php endforeach;?>
        </table>
    </body>
</html>
