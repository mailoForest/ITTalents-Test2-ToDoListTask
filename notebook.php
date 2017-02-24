<?php
$notes = [];
$delNote = 0;
if (isset($_POST['submit'])){
    $priority = trim($_POST['priority']);
    $note = trim($_POST['note']);

    if ($note === '' || strlen($note) > 50){
        echo "Cannot scribe empty notes or more than 50 chars!";
    } else if(!is_numeric($priority) || $priority > 5 || $priority < 1){
        echo "Wrong priority!";
    } else {
        $note = htmlentities($note) . "#$priority";

        $handle = fopen("notes.txt", 'r');

            while (!feof($handle)){
                $line = trim(fgets($handle));

                if ($line !== ''){
                    $notes[] = $line;
                }
            }
            $notes[] = $note;
        fclose($handle);

        $implodedFile = implode("\r\n", $notes);
        file_put_contents('notes.txt', $implodedFile);
    }
}

if (isset($_POST['delete']) && isset($_POST['delNote']) && is_numeric($_POST['delNote']) && $_POST['delNote'] >= 1) {
    $delNote = $_POST['delNote'];

    $notes = explode("\n",file_get_contents('notes.txt'));

    array_splice($notes, $delNote - 1, 1);

    $implodedFile = implode("\n", $notes);

    file_put_contents('notes.txt', $implodedFile);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task</title>
    <style>
        #pink{
            height: 14em;
            float: right;
        }
        .icon{
            height: 2em;
        }
        *{
            font-family: sans-serif;
        }
        ol{
            overflow: scroll;
            height: 15em;
        }
    </style>
</head>
<body>
<audio src="Pink-Panther-Theme-Song.mp3" autoplay loop></audio>
<fieldset>
    <legend>Write in</legend>

    <img id="pink" src="https://images-cdn.9gag.com/photo/aD0GXDO_700b.jpg" alt="">
    <form action="./notebook.php" method="post">
        <div><label for="note">Enter your note below:</label></div>
        <div><textarea name="note" maxlength="50" id="note" cols="30" rows="10" placeholder="..." required></textarea></div>
        <div><label for="priority">Enter priority: </label><input name="priority" maxlength="2" id="priority" style="width: 2em;" placeholder="..." required></div>
        <br>
        <input type="submit" name="submit" value="Scribe note">
    </form>
    <form action="./notebook.php" method="post">
        <hr>
        <label for="delNote">Enter the serial number of the note you wish to delete: <input type="text" id="delNote" name="delNote" maxlength="2"></label>
        <input type="submit" value="Delete" name="delete">
    </form>
</fieldset>
<h2>Your notes so far:</h2>
<ol>
    <?php

    $handle = fopen('notes.txt', 'r');
    $image = '';

    while(!feof($handle)) {
        include 'priority.php';

        switch ($priority){
            case 0: $image = ""; break;
            case 1: $image = "images/1.png"; break;
            case 2: $image = "images/2.png"; break;
            case 3: $image = "images/3.png"; break;
            case 4: $image = "images/4.gif"; break;
            case 5: $image = "images/5.png"; break;
        }
        echo "<li>$line<img class='icon' src=\"$image\"></li>";
    }
    fclose($handle);
    ?>
</ol>
<a href="showNotes.php">See all your notes</a>
</body>
</html>
