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
$category=(int)$_POST['category'];
if ($category<1){
   // wp_redirect( esc_url( $_SERVER['REQUEST_URI'] ) );
    exit;
}
$titles_c= count(explode("\n",$_POST['titles'])); //ключи
if ($titles_c<4){
    //wp_redirect( esc_url( $_SERVER['REQUEST_URI'] ) );
    exit;
}


?>
            <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" >

                <br>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Отправить на генерацию GPT</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                    <div id="col_head_deskHelp" class="form-text">введите пароль 555</div>
                    <input name="category" type="text" value="<?=$category?>" class="form-control" hidden>
                </div>
                <br>
            <hr>
                <button type="submit" class="btn btn-danger ms-4">Продолжить</button>
            </form>

<?php

include_once("set.php");
$curlHandle = curl_init($api.'/gpt/text.php');
curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

$curlResponse = curl_exec($curlHandle);
curl_close($curlHandle);

$all_text=file_get_contents($api.'/gpt/');


?>
        </div>
        <div class="col-xl">
           <?=$all_text?>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
