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
    </head>
    <body>
        <table>
            <?php $i = 0; ?>
            <?php foreach ($elements as $element): ?>
                <?php if ($element->position == 0): ?>
                    <?php $i = 0 ?>
                    <tr>
                <?php endif; ?>
                <?php while ($element->position != $i):?>
                    <td style="padding:10px"></td>
                    <?php $i++ ?>
                <?php endwhile;?>
                <?php $i++ ?>

                <?php if ($element->position == 17): ?> 
                    <td style="border: 1px solid black; padding:10px; color:white; background-color:#623842">
                <?php else : ?>
                    <td style="border: 1px solid black; padding:10px;">
                    
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
