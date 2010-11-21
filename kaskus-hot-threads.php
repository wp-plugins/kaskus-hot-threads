<?php
/*
Plugin Name: Kaskus Hot Threads
Plugin URI: http://bintangweb.com/wordpress-plugin-kaskus-hot-threads/
Description: Menampilkan Kaskus Hot Threads di widget
Author: Bintangweb.com
Version: 1.0
Author URI: http://bintangweb.com/
*/

function file_get_contents_curl($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  //Set curl to return the data instead of printing it to the browser.
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function getht(){
    $data=file_get_contents_curl("http://www.kaskus.us/");
    preg_match('/(<ul>)(.*)/', $data, $p);
    preg_match('/(.*)(<\/ul>)/', $p[2], $s);
    return $s[1];
}

function showht() {
    $ht = getht();
    $href1 = str_replace('showthread','http://www.kaskus.us/showthread',$ht);
    $strong1 = str_replace('<strong>','',$href1);
    $strong2 = str_replace('</strong>','',$strong1);
    echo $strong2;
}

function widgetht($args) {
    extract($args);
    echo $before_widget;
    echo $before_title;
    ?>Kaskus Hot Threads<?php
    echo $after_title;
    echo "<ul>";
    showht();
    echo "</ul>";
    echo $after_widget;
}

function ht_init() {
    register_sidebar_widget(__('Kaskus Hot Threads'), 'widgetht');
}

add_action("plugins_loaded", "ht_init");

?>
