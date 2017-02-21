<h2>Your notes ordered:</h2>
<table border="1">
    <?php
    $notes = [];

    for ($i = 0; $i <= 5; $i++){
        $notes[] = [];
    }
    $getPriority = 0;
    $longestListOfPriorities = 0;
    $handle = fopen('notes.txt','r');
        while (!feof($handle)){
            $line = fgets($handle);
            $getPriority = strstr($line, '#');
            $getPriority = str_replace('#', '', $getPriority);
            $getPriority += 0;

            $notes[$getPriority][] = $line;
        }

//        foreach ($notes as $note){
//            $countNotes = count($note);
//            if ($longestListOfPriorities < $countNotes){
//                $longestListOfPriorities = $countNotes;
//            }
//        }
    ?>

    <tr><th>Priority</th><th>Text</th></tr>
    <?php
        for ($i = 0; $i <= 5; $i++){
            echo "<tr><td>$i</td>";
            echo "<td>". implode("<br/>",$notes[$i]) ."</td></tr>";
        }
    ?>
<?php
    fclose($handle);
    var_dump($notes);
?>
</table>