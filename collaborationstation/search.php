<?php
require_once 'header.php';

$view = sanitizeString($_GET['q']);

//showProfile($view);
searchProfile($view);
die(require 'footer.php');

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;



require_once 'footer.php';
?>
