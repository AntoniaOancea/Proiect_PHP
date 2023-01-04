<?php
    include('simple_html_dom.php');
    $html = file_get_html("https://romaniadategeografice.net/acasa/judetele-romaniei/");

    echo $html->find("table",0);
 
?>
