<?php
require_once 'header.php';

$view = sanitizeString($_GET['q']);

echo '<form id="form" role="search" action="search.php">
      <input type="search" id="query" name="q"
       placeholder="Search Users..."
       aria-label="Search through site content">
      <button>Search</button>
    </form>';
//showProfile($view);
searchProfile($view);
die(require 'footer.php');

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;



require_once 'footer.php';
?>
