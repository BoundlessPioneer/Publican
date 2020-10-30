<?php

/*
echo "Cookie test";

$testId = "123456789";

$time = time();

setcookie($testId, $time);
*/

if(!isset($_COOKIE['publican_cookie'])) {

    echo "<p>Publican Cookie Not Found\n</p><br>";

} else {
    

    echo "<p>Publican Cookie Found!</p><br>";

    echo "<br><p>" . $_COOKIE['publican_cookie'] . "</p><br>";
}

?>