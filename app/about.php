<?php
session_start();
echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
$browser = get_browser(null, true);
print_r($_SERVER);
?>