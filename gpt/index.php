<?php
require_once "simple_html_dom.php";
$all_text=file_get_contents('file_desk/1.txt');



if(isset($_GET['title'])){
    if($_GET['title']=="get"){
        $html = str_get_html($all_text);
        echo $html->find('h1',0)->plaintext;
    }
}

if(isset($_GET['body'])){
    if($_GET['body']=="get"){
        $html = str_get_html($all_text);
        $html->find('h1',0)->outertext='';
        echo $html;
    }else{
        if(!isset($_GET['title'])) {
            echo $all_text;
        }
    }
}else{
    if(!isset($_GET['title'])) {
        echo $all_text;
    }
}