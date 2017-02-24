<?php

$line = trim(fgets($handle));

$lastChar = mb_strlen($line)-1;
$priority = 0;
if ($line !== '' && $line{$lastChar-1} === "#" && is_numeric($lastChar) && $line{$lastChar} <= 5) {
    $priority = $line{$lastChar} + 0;
}