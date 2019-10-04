<?php
include "crawler_function.php";
// header(COOKIE);
$iron_url = 'https://ithelp.ithome.com.tw/2020ironman/create/2463';
$ch = curl_init($iron_url);

$result = crawlOnePage($ch);
// echo $result;
// die();
$dom = domParser($result);
$tag = $dom->getElementsByTagName('a')[0]->nodeValue;
preg_match('/articles\/(.+)\/draft/', $tag, $m);
$article_id = $m[1];

$form_url = "https://ithelp.ithome.com.tw/articles/$article_id/draft";
$ch = curl_init($form_url);
$result = crawlOnePage($ch);

$dom = domParser($result);

$xpath = new DOMXPath($dom);
$nodeList = $xpath->query('//input[@name="_token"]');
$tag = $nodeList->item(0);
$token = $tag->getAttribute('value');
// $tag = $dom->getElementsByTagName('input');
// var_dump($token);
// die();

$post_url = "https://ithelp.ithome.com.tw/articles/$article_id/publish";
$ch_post = curl_init($post_url);
// var_dump($post_url);
$date = date("Y-m-d");
$title = file_get_contents("$date.txt");
$content = file_get_contents("$date.md");

$post_data = [
    '_token' => $token,
    '_method' => 'PUT',
    'subject' => $title,
    'description' => $content,
    'tags[0]' => '11th鐵人賽',
    'tags[1]' => 'laravel',
    'tags[2]' => 'php',
    'tags[3]' => 'restful api',
];

$output = publishPost($ch_post, $post_data);
$dom = domParser($output);
$url = $dom->getElementsByTagName('a')[0]->nodeValue;

if($url == "https://ithelp.ithome.com.tw/articles/$article_id"){
    echo "Success";
}else{
    echo "Failed!!";
}