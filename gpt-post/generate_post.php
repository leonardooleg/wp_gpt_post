<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GPT Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/wp-admin/admin.php?page=gptpost">GPT-Post</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/wp-admin/admin.php?page=gptpost">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" >Сгенерирован текст</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" >Текст создан ботом GPT</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-md">
            <hr><br>

<?php

include_once("set.php");
$category=$_POST['category'];

$title = file_get_contents($api.'/gpt/?title=get');
$body = file_get_contents($api.'/gpt/?body=get');



$my_post = array(
    'post_title'    => wp_strip_all_tags( $title ),
    'post_content'  => $body ,
    'post_status'   => 'pending',
    'post_author'   => 1,
    'post_category' => [(int)$category]
);

// Insert the post into the database
$post_id=wp_insert_post( $my_post );
$_POST = array();
?>


                <br>
            <a class="" href="/wp-admin/post.php?post=<?=$post_id?>&action=edit">Изменить и опубликовать пост</a>
                <br>
            <hr>
        </div>
        <div class="col-xl">
           <?=$title.$body?>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
