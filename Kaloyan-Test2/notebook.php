<?php
$notes = [];
if (isset($_POST['submit'])){
    $priority = htmlentities($_POST['priority']);
    $note = htmlentities($_POST['note']);

    if ($note === '' || $note === '\n' ||  strlen($note) < 1 || strlen($note) > 50){
        echo "Cannot send empty notes or ore than 50 chars!";
    } else if(!is_numeric($priority) || $priority > 5 || $priority < 1){
        echo "Wrong priority!";
    } else {

        $note .= "#$priority";

        $handle2 = fopen("notes.txt", 'r');
            while (!feof($handle2)){
                $line = fgets($handle2);

                $notes[] = $line;
            }
        fclose($handle2);

//        $image = 'images/';
//        switch ($priority){
//            case 1: $image .= "1.png"; break;
//            case 2: $image .= "2.png"; break;
//            case 3: $image .= "3.gif"; break;
//            case 4: $image .= "4.png"; break;
//            case 5: $image .= "5.png"; break;
//        }

        $handle1 = fopen('notes.txt','w');
            $notes[] = "\r\n$note";

            foreach ($notes as $n) {
                fwrite($handle1, $n);
            }
        fclose($handle1);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task</title>
    <style>
        img{
            height: 1em;
        }
    </style>
</head>
<body>
<fieldset>
    <legend>Write in</legend>

    <form action="./notebook.php" method="post">
        <div><label for="note">Enter your note below:</label></div>
        <div><textarea name="note" maxlength="50" id="note" cols="30" rows="10" placeholder="..."></textarea></div>
        <div><label for="priority">Enter priority: </label><input name="priority" maxlength="1" id="priority" style="width: 2em;" placeholder="..."></div>
        <input type="submit" name="submit" value="Scribe note">
    </form>

</fieldset>
<h2>Your notes so far:</h2>
<ul>
    <?php
    $handle = fopen('notes.txt','r');
    while (!feof($handle)){
        $line = fgets($handle);
        echo "<li>$line</li>";
    }
    fclose($handle);
    ?>
</ul>
<a href="showNotes.php">See all your notes</a>
</body>
</html>
