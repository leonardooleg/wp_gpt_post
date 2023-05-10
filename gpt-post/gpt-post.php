<?php
/*
  Plugin Name: GPT create post
  Plugin URI: https://my-awesomeness-emporium.com
  description: >-
 a plugin to create awesomeness and spread joy
  Version: 1.2
  Author: Mr. Awesome
  Author URI: https://mrtotallyawesome.com
  License: GPL2
  */


/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page(){
   add_menu_page(
        __( 'Custom Menu Title', 'gptpost' ),
        'GPT Post',
        'manage_options',
        'gptpost',
        'my_custom_menu_page',
        plugins_url( 'gpt-post/chatgpt-icon.png' ),
        6
    );


}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
function generate_text(){
    if ( isset( $_POST['category'] ) and  !isset( $_POST['password'] )  and ! isset( $_POST['create_post'] )) {
        include "generate_text.php";
    }
}
function  generate_gpt(){
    if ( isset( $_POST['password'] ) and  isset( $_POST['category'] )  and ! isset( $_POST['create_post'] ) ) {
        include "generate_gpt.php";
    }
}
function  generate_post(){
    if ( isset( $_POST['create_post'] ) and  isset( $_POST['category'] )  and  !isset( $_POST['password'] )) {
        include "generate_post.php";
    }
}
function     html_form_code(){
if ( !isset( $_POST['category'] ) ) {
    ?>
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
                        <a class="nav-link active" aria-current="page" href="/wp-admin/admin.php?page=gptpost">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" >Сгенерирован текст</a>
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
            <h1>Генератор поста!</h1>
            <hr><br>

            <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" >

                <select name="category" class="form-select" aria-label="Default select example" required>
                    <option>Категория для поста</option>
                    <?php
                    $categories = get_categories( array(
                            'hide_empty'      => false,
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    ) );

                    foreach($categories as $category) {
                        echo ' <option value="' . $category->term_id. '">' . $category->term_id. '. ' . $category->name . '</option>';
                    }
                    ?>
                </select>
                <br>
                <div class="mb-3">
                    <label for="FormControlTextarea1" class="form-label">Главные ключи</label>
                    <textarea name="titles" class="form-control" id="FormControlTextarea1" rows="5"></textarea>
                </div>
                <hr><br>
                <button type="submit" class="btn btn-primary">Продолжить</button>
            </form>
        </div>

        <div class="col-xl">

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
}
}
function my_custom_menu_page(){
    html_form_code();
    generate_text();
    generate_gpt();
    generate_post();
}


?>





