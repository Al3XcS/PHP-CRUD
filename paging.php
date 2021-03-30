<?php

echo "<ul class='pagination pull-left margin-zero mt0'>";

//butonul pentru prima pagina
if($page>1){
    $prev_page = $page - 1;
    echo "<li>";
        echo "<a href='{$page_url}page={$prev_page}'>";
            echo "<span style='margin:0 .5em;'>«</span>";
        echo "</a>";
    echo "</li>";        
}

//numerele pe care poti da click
//numarul de pagini pe care poti da click

//descopera numarul total de pagini
$total_pages = ceil($total_rows / $records_per_page);

//raza de numere/link-uri de aratat
$range = 1;

//adauga raza de pagini in jurul paginii curente
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) +1;

for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    //ne asiguram ca $x e mai mare decat 0 si mai mic sau egal cu numarul total de pagini
    if (($x > 0) && ($x <= $total_pages)) {
        //pagina curenta
        if($x == $page) {
            echo "<li class='active'>";
                echo "<a href='javascript::void();'>{$x}</a>";
            echo "</li>";
        }

        //daca nu e pagina curenta
        else {
            echo "<li>";
                echo "<a href='{$page_url}page={$x}'>{$x}</a> ";
            echo "</li>";
        }
    }
}

// butonul pentru ultima pagina
if($page<$total_pages) {
    $next_page = $page + 1;

    echo "<li>";
        echo "<a href='{$page_url}page={$next_page}'>";
            echo "<span style='margin:0 .5em;'>»</span>";
        echo "</a>";
    echo "</li>";
}

echo "</ul>";
?>