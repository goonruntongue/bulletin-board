<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") :
    $date = $_POST["timestamp"];
    unlink("data/data-{$date}.txt");
    $contents = "";
    $files = glob("data/*.txt");
    foreach ($files as $file) {
        $contents .= file_get_contents($file);
    }
    echo $contents;
endif;