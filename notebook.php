<?php
$notes = [];
$image = '';
$delNote = 0;
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

        $notes[] = "\r\n$note";

        $handle1 = fopen('notes.txt','w');

        foreach ($notes as $n) {
            fwrite($handle1, $n);
        }

        fclose($handle1);
    }
}
$explodedFile = explode("\n", file_get_contents('notes.txt'));

if (isset($_GET['delNote']) && is_numeric($_GET['delNote']) && $_GET['delNote'] <= count($explodedFile) && $_GET['delNote'] >= 1) {
    $delNote = $_GET['delNote'];
    unset($explodedFile[$delNote - 1]);

    $implodedFile = implode("\r\n", $explodedFile);

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
    <form action="./notebook.php">
        <hr>
        <label for="delNote">Enter the serial number of the note you wish to delete: <input type="text" id="delNote" name="delNote" maxlength="2"></label>
        <input type="submit" value="Delete" name="delete">
    </form>
</fieldset>
<h2>Your notes so far:</h2>
<ol>
    <?php
    $handle = fopen('notes.txt','r');
    while (!feof($handle)){
        $line = fgets($handle);

        include 'getPriority.php';

        switch ($getPriority){
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
