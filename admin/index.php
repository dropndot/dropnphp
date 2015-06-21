<?php

$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = str_replace('/admin/', '/', $url);
$redirect_to = $url . "index.php?controller=login";
header("HTTP/1.1 301 Moved Permanently");
header("Location: $redirect_to");
exit();
?>