<?php

if(is_dir("file_desk/")) {
    dirDel("file_desk/"); //удалить старые файлы
}

$titles= explode("\n",$_POST['titles']); //ключи
$category=$_POST['category'];
$col_head_desk = "250-400"; // из скольких символов в начале странице будет описание
$col_head_desk_2 = "100-200"; // из скольких символов в начале странице будет описание #2
$col_body_text=12;  //количество миниобзоров на странице всего
$col_body_text_desk="250-400";  //из скольких абзацев будет описание каждого H2
$col_body_text_desk_cons=2;  //сколько  минусов  в описание каждого H2
$col_body_text_desk_pros=4;  //сколько  плюсов  в описание каждого H2

$col_menu=7;  //сколько из $col_body_text  будет в начале пунктами меню !!!!

/*Ссылки на сайт в ТОП 10*/
$sites_top=3; // сколько ссылок с анкором вставить в меню сайта из файла /text/sites_top.txt
$sites_top_sort=2; // какая очередность добавление ссылок 1 - рандомно, 2 - по очереди
/*Ссылки на сайт в ТОП 10*/

/*Ссылки на сайт после ТОП */
$sites_h2=2; // сколько ссылок после ТОП вставлять в H2 сайта из файла /text/sites.txt
$sites_h2_sort=2; // очередность добавление ссылок: 1 - в h2 или в плюсы, 2 - в h2, 3 - в плюсы
$sites_h2_sort_file=2; // прать из файла 1- случайно, 2 - по порядку
/*Ссылки на сайт после ТОП*/

$col_footer_desk = "200-300"; // из скольких символов описание перед футером о "Responsible Gambling Disclaimer"






//генерация описаний h2
$descriptions_cat=array_filter(explode(PHP_EOL,file_get_contents(__DIR__ . '/text/desc_cat_' .$category.'.txt')));

$descriptions_cons=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/cons.txt'));
shuffle($descriptions_cons);

$descriptions_pros=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/pros.txt'));
shuffle($descriptions_pros);

$link_text=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/link.txt'));
shuffle($link_text);

$link_desk=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/link_desk.txt'));
shuffle($link_desk);

$link_sites_top=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/sites_top.txt'));


$link_sites_h2=explode(PHP_EOL,file_get_contents(__DIR__ . '/text/sites.txt'));


$footer_text = file_get_contents(__DIR__ . '/text/footer.txt');


if ($sites_top>$col_menu) {$sites_top=$col_menu;}


$one_links=[];
$need_body_text=$col_body_text-1;
$n=1;
$menu_link=[];
$text=[];
$link=0;
$desk_cons=0;
$desk_pros=0;
$c_sites_h2=0;
$sites_h2_sort_random=0;
$limit_random_array_values = range(0, $need_body_text);
shuffle($limit_random_array_values);
$all_random_array_value = array_slice($limit_random_array_values ,0,90);

//случайное число для вставки ссылок
$sites_top_array=rand_array(1,10, $sites_top_sort,$sites_top);
//случайное число массива ссылок
$link_sites_top_array = rand_array(0, count($link_sites_top) - 1, $sites_top_sort, $sites_top);
//массив минусов в описании
$descriptions_cons_array = rand_array(0, count($descriptions_cons) - 1, 1, $col_body_text_desk_cons*$col_body_text);
//массив плюсов в описании
$descriptions_pros_array = rand_array(0, count($descriptions_pros) - 1, 1, $col_body_text_desk_pros*$col_body_text);
//массив для ссылок после топа в h2
$link_sites_h2_array = rand_array($col_menu+1, $col_body_text, $sites_h2_sort_file, $sites_h2);


/*Начало поста*/

//заголовок
$head_text= "<h1>$titles[0]</h1>";
//заглавное описание
$head_text .= '<p>';

//запрос в бот
$bot_text_1 = "<span class='bot'> GPT - come up with a description:<b> $titles[1] </b> in <b>$col_head_desk </b>characters</span>";
$head_text .= $bot_text_1;

$head_text .= '</p><br>';

$head_text .= "<h2>$titles[2]</h2>";





$menu_link[]='<ul>';
foreach ($all_random_array_value as $random_array_id ){
    $menu_name = $link_text[$random_array_id];
    $menu_key = $link_desk[$random_array_id];
    //создаем меню
    if($n<=$col_menu){
        if($sites_top>=1) {
            if (in_array($n,$sites_top_array)) {
                $menu_name= $link_sites_top[$link_sites_top_array[$link]] ;
            }
        }
        $menu_link[] = '<li>' . $menu_name . ' : ' . $menu_key . '</li>';
    }


    //запрос в бот для описания 2
    $bot_text_2 = "<span class='bot'>GPT - come up with a description:<b> $titles[3] </b> in <b>$col_head_desk_2 </b>characters</span>";
    $head_text_2 = "<p>$bot_text_2</p>";


    if (in_array($n,$sites_top_array) and $sites_top>=1) {
        $menu_name =strip_tags($link_sites_top[$link_sites_top_array[$link]]);
    }
    if (in_array($n,$link_sites_h2_array) and $sites_h2_sort==1) $sites_h2_sort_random= rand(1,2);
    if(in_array($n,$link_sites_h2_array) and $sites_h2_sort_random==1 || $sites_h2_sort==2) {
        $menu_key = $link_sites_h2[$c_sites_h2];
    }
    $temp_text = '<h2 id="menu'.$n.'">'. $n .'. '.$menu_name.' - '.$menu_key.'</h2><p>';
    $bot_text_3 = "<span class='bot'>GPT - write about:";
    for($i=0;$i<=count($descriptions_cat) - 1;$i++) {
        $bot_text_3 .=  $menu_name.' - ' . $descriptions_cat[$i] .'. ';
    }
    $bot_text_3 .= "in <b>$col_body_text_desk </b>characters </span>";
    $temp_text .= $bot_text_3;

    //$gpt_head="description in $col_body_text_desk sentences. write a review ";
    //$temp_text .=gpt_desk($gpt_head.$menu_name.' - '.$menu_key);
    $temp_text .= '</p>';

    if ($col_body_text_desk_cons>=1){
        $temp_text .= ' Cons: <ul>';
        for ($c=1;$c<=$col_body_text_desk_cons;$c++){
            $temp_text .= '<li>'.$descriptions_cons[$descriptions_cons_array[$desk_cons]].'</li>';
            $desk_cons++;
        }
        $temp_text .= '</ul>';
    }
    if ($col_body_text_desk_pros>=1){
        $temp_text .= ' Pros: <ul>';
        for ($c=1;$c<=$col_body_text_desk_pros;$c++){
            if ($sites_h2_sort_random==2 || $sites_h2_sort==3 ) {
                if (in_array($n,$link_sites_h2_array) and $c==$col_body_text_desk_pros) {
                    $temp_text .= '<li>' .  $link_sites_h2[$c_sites_h2] . '</li>';
                }else{
                    $temp_text .= '<li>' . $descriptions_pros[$descriptions_pros_array[$desk_pros]] . '</li>';
                }
            }else{
                $temp_text .= '<li>' . $descriptions_pros[$descriptions_pros_array[$desk_pros]] . '</li>';
            }
            $desk_pros++;
        }
        $temp_text .= '</ul>';
    }




    $temp_text = str_replace('-URL-', $menu_name, $temp_text);


    $text[] = $temp_text;

    if (in_array($n,$sites_top_array)) $link++;
    if (in_array($n,$link_sites_h2_array))  $c_sites_h2++;
    $n++;
}
$menu_link[]='</ul><br><br>';
$menu_link=implode(' ',$menu_link);

//запрос в бот
$bot_text_3 = "<span class='bot'>GPT - come up with a description:<b> Responsible Gambling Disclaimer </b> in <b>$col_footer_desk </b>characters</span>";
$footer_text = "<h2>Responsible Gambling Disclaimer</h2> <p>$bot_text_3</p ><p>$footer_text</p>";

$all_text = $head_text.$menu_link.$head_text_2.implode(' ', $text).$footer_text;





if (!file_exists(__DIR__ . '/file_desk')) {
    mkdir(__DIR__ . '/file_desk', 0777, true);
}
if (!file_exists(__DIR__ . '/file_desk')) {
    mkdir(__DIR__ . '/file_desk', 0777, true);
}
file_put_contents(__DIR__ . '/file_desk/1.txt',$all_text);



function dirDel ($dir)
{
    $d=opendir($dir);
    while(($entry=readdir($d))!==false)
    {
        if ($entry != "." && $entry != "..")
        {
            if (is_dir($dir."/".$entry))
            {
                dirDel($dir."/".$entry);
            }
            else
            {
                unlink ($dir."/".$entry);
            }
        }
    }
    closedir($d);
    rmdir ($dir);
}


function rand_array($start, $max, $sort,$all){
    $array_return=array();
    for ($s=$start;$s<=$all+$start-1;$s++){
        if ($sort==1){
            $rand=rand($start,$max);
            if( in_array( $rand ,$array_return ) ) {
                $rand=rand($start,$max);
                if( in_array( $rand ,$array_return ) ) {
                    $rand=rand($start,$max);
                    if( in_array( $rand ,$array_return ) ) {
                        $rand=rand($start,$max);
                        if( in_array( $rand ,$array_return ) ) {
                            $rand=rand($start,$max);
                            if( in_array( $rand ,$array_return ) ) {
                                $rand=rand($start,$max);
                                if( in_array( $rand ,$array_return ) ) {
                                    $rand=rand($start,$max);
                                    if( in_array( $rand ,$array_return ) ) {
                                        $rand=rand($start,$max);
                                        if( in_array( $rand ,$array_return ) ) {
                                            $rand=rand($start,$max);
                                            if( in_array( $rand ,$array_return ) ) {
                                                $rand=rand($start,$max);

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $array_return[]=$rand;
        }else{
            $array_return[]=$s;
        }
    }
    return $array_return;
}

function gpt_desk($need_text) {
    $api_key = "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";
    $prompt = array(array("role" => "user", "content" => $need_text));
    $url = "https://api.openai.com/v1/chat/completions";

    $data = array(
        "model" => "gpt-4",
        "messages" => $prompt
    );

    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return "Error: " . curl_error($ch);
    }

    curl_close($ch);

    $response_data = json_decode($response, true);
    if(isset($response_data["error"]["message"])) $generated_text =$response_data["error"]["message"];
    else $generated_text = $response_data["choices"][0]["message"]["content"];

    return $generated_text;
}
