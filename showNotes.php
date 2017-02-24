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

    $handle = fopen('notes.txt','r');


    while (!feof($handle)){
        include 'priority.php';

        $notes[$priority][] = $line;
    }
    ?>
    <thead><tr><th>Priority</th><th>Text</th></tr></thead>
    <tbody>
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

            echo "<tr $style><td>$i</td>" . "<td>" . implode("<br/>",$notes[$i]) . "</td></tr>";
        }
        fclose($handle);
        ?>
    </tbody>
</table>
<br/>
<a href="notebook.php">Go Back</a>
</body>