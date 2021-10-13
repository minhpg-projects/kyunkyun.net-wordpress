<?php
header('Content-Type: text/x-subrip; charset=utf-8');
if(isset($_GET['file']) && $_GET['file'])
{
    $file = strip_tags($_GET['file']);

    $allowed_file_type = ['vtt', 'srt', 'ass'];

    $file_type = halim_check_file_extension($file);

    if(!strpos($file, 'config') && in_array($file_type, $allowed_file_type)) {
        $content = get_content($file);
        echo $content;
    } else {
        echo 'File type not allowed!';
    }
}

function get_content($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_REFERER, 'https://google.com');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}

function halim_check_file_extension($url) {
    return preg_replace("#(.+)?\.(\w+)(\?.+)?#", "$2", $url);
}