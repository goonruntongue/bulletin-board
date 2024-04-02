<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") :
    date_default_timezone_set("asia/tokyo");
    $timestamp = date("Y年m月d日H時i分s秒");
    $datetime = date("Y-m-d-h-i-s");
    $file = "data/data-{$timestamp}.txt";
    function esc_html($arg)
    {
        return htmlspecialchars($arg, ENT_QUOTES);
    }
    $comment = "<div class='comment' data-timestamp='{$timestamp}'>" . "<time datetime='{$datetime}'>投稿日：{$timestamp}</time>" . "<div class='contentsColumn'><div class='post'>" . nl2br(str_replace(" ", "&nbsp;", esc_html($_POST["comment"]))) . "</div>";
    $Img = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) :
        $files = $_FILES["image"];
        $from = $files["tmp_name"];
        $to = "uploads/" . basename($files["name"]);
        move_uploaded_file($from, $to);
        if ($_FILES["image"]["type"] == "video/mp4") :
            $Img = "<div class='videoBox fractal'><video src={$to} controls loop autoplay muted></video></div>";
        else :
            $Img = "<div class='imageBox fractal'><img src={$to}></div>";
        endif;
    endif;
    if ($Img != "") :
        file_put_contents($file, $comment . $Img . "</div></div>", FILE_APPEND);
    else :
        file_put_contents($file, $comment . "</div></div>", FILE_APPEND);
    endif;
endif;
//ファイル群を配列として取得
$fileArr = glob("data/*.txt");
// ファイル群それぞれを処理
$contents = "";
foreach ($fileArr as $onefile) {
    $contents .= file_get_contents($onefile);
}
echo $contents;