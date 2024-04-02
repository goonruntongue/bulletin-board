<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") :
    date_default_timezone_set("asia/tokyo");
    $timestamp = date("Y年m月d日h時i分s秒");
    $datetime = date("Y-m-d-h-i-s");
    $file = "data/data-{$timestamp}.txt";
    function esc_html($arg)
    {
        return htmlspecialchars($arg, ENT_QUOTES);
    }
    $comment = "<p class='comment' data-timestamp='{$timestamp}'>" . "<time datetime='{$datetime}'>投稿日：{$timestamp}</time>" . nl2br(str_replace(" ", "&nbsp;", esc_html($_POST["comment"]))) . "</p>";
    file_put_contents($file, $comment, FILE_APPEND);
endif;
//ファイル群を配列として取得
$fileArr = glob("data/*.txt");
// ファイル群それぞれを処理
$contents = "";
foreach ($fileArr as $onefile) {
    $contents .= file_get_contents($onefile);
}
echo $contents;