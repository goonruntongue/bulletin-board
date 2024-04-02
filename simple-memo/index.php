<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400;500;600;700;800;900&family=Oswald:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="container">
        <form action="backend.php" method="post">
            <textarea name="comment"></textarea>
            <input type="submit" value="書き込み">
        </form>
        <div class="flex updown">
            <i class="fa-solid fa-arrow-up-z-a"></i>
        </div>
        <div class="res">
        </div>
    </div>
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(() => {
        $.get("read-write.php", (data) => {
            $(".res").empty().append(data);
            $(".comment").each(function() {
                $(this).append('<i class="fa-solid fa-trash"></i>');
            })
        })
    })
    $("form").on("submit", e => {
        e.preventDefault();
        let data = $("form").serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: "read-write.php",
            success: (data) => {
                $("textarea").val("");
                $(".res").empty().append(data);
                $(".comment").each(function() {
                    $(this).append('<i class="fa-solid fa-trash"></i>');
                })
            }
        })
    });
    $(document).on("click", ".comment i", function() {
        let flg = confirm("このデータを削除しますか？");
        if (!flg) {
            return;
        }
        let key = $(this).closest(".comment").data("timestamp");
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: {
                timestamp: key
            },
            success: (data) => {
                $(".res").empty().append(data);
                $(".comment").each(function() {
                    $(this).append('<i class="fa-solid fa-trash"></i>');
                })
            }
        })
    });
    let flg = true;
    $(".updown i").on("click", function() {
        if (flg) {
            $(".res").css({
                "flex-direction": "column-reverse"
            });
            $(this).removeAttr("class").addClass("fa-solid fa-arrow-down-a-z");
        } else {
            $(".res").css({
                "flex-direction": "column"
            })
            $(this).removeAttr("class").addClass("fa-solid fa-arrow-up-z-a");
        }
        flg = !flg;
    })
    </script>
</body>

</html>