<?
$locale = $_COOKIE["locale"] ?? "fr";
$lang = require "lang-$locale.php";

function lang($str){
    global $lang;
    return !empty($str) ? $lang[$str] : $str;
}