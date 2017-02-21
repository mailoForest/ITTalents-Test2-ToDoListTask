<head>
    <title>My notes in a table</title>
    <style>
        *{
            font-family: sans-serif;
        }
    </style>
</head>
<body>
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

        include "getPriority.php";

        $notes[$getPriority][] = $line;
    }
    ?>
    <tr><th>Priority</th><th>Text</th></tr>
    <?php
        $color = '';
    for ($i = 0; $i <= 5; $i++){

        if ($i == 1 || $i == 2){
            $color = 'green';
        } else if ($i == 2 || $i == 3){
            $color = 'yellow';
        } else if ($i == 5){
            $color = 'red';
        }
        $style = "style='background:$color;'";

        echo "<tr $style><td>$i</td>";
            echo "<td>". implode("<br/>",$notes[$i]) ."</td></tr>";
        }
    fclose($handle);
    ?>
</table>
<br/>
<a href="notebook.php">Go Back</a>
</body>