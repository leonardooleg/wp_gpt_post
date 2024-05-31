<?php
set_time_limit(0);// to infinity for example


if (isset($_POST['category'])){
        $category=$_POST['category'];
        require_once "simple_html_dom.php";

        $all_text=file_get_contents( "file_desk/1.txt");
        $all_text = str_replace('GPT -','',$all_text);
        $html = str_get_html($all_text);

        foreach($html->find('span.bot') as $element){
            $element->outertext =  gpt_desk($element->plaintext);
            file_put_contents("file_desk/1.txt", $html);
        }

        file_put_contents("file_desk/1.txt", $html);
}

function gpt_desk($need_text) {
    $api_key = "";
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
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 700); //timeout in seconds
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
