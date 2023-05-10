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
                        <a class="nav-link " >Сгенерирован текст</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" >Текст создан ботом GPT</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-md">
            <hr><br>

<?php
set_time_limit(0);// to infinity for example

$password=false;
if (isset($_POST['password'])) {
    if ($_POST['password'] == "555") {
        $category = $_POST['category'];
        $_POST['password'] = false;
        $password = true;

       include_once("set.php");
        $curlHandle = curl_init($api.'/gpt/gpt.php');
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($curlHandle);
        curl_close($curlHandle);

        $all_text=file_get_contents($api.'/gpt/');

    }
}
if($password){
?>

            <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" >

                <br>
                <div class="mb-3">
                    <input name="create_post" type="text" value="1" class="form-control" id="exampleInputPassword1" hidden>
                    <input name="category" type="text" value="<?=$category?>" class="form-control" hidden>
                </div>
                <br>
                <hr>
                <button type="submit" class="btn btn-danger ms-4">Создать пост</button>
            </form>
        </div>
        <div class="col-xl">
            <?php

                echo $all_text;
            }else{
                echo "<b>нету пароля!</b>";
            }
            ?>

        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
