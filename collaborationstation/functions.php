<?php
$dbhost  = 'localhost';

$dbname  = 'db35';   // Modify these...
$dbuser  = 'user35';   // ...variables according
$dbpass  = '35fils';   // ...to your installation

echo <<<_INIT
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <script src='javascript.js'></script>
        <link href="https://fonts.googleapis.com/css?family=Arsenal|Lora|Muli|Source+Sans+Pro|Playfair+Display&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='css/styles.css'>
        <title>$clubstr: $userstr</title>
        </head>
_INIT;

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}

function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var){
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc())
        $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user) {

  if (file_exists("userpics/$user.jpg"))
      echo "<img class='userpic' src='userpics/$user.jpg'>";

  $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

  if ($result->num_rows) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
  }
  //TODO fix that shit
  //else echo "<p>No Profile Photo</p><br>";

  //Code that shows user's uploaded songs
    foreach(glob("useraudio/$user*.mp3") as $file){
      $shortName = explode(".", basename($file));
      echo "<div style='display: inline-block; overflow:auto;>";
      echo ("<p style='float: left; padding-right: 2em;'><b>$shortName[1]</b></p>");
      if (file_exists($file)){
        echo "
        <audio controls style='float: left; padding-right: 2em;'>
          <source src='$file' type='audio/mp3'>
          Your browser does not support the audio element.
        </audio>
        ";
      }
      echo "</div>";
    }


}

function showDiscover($user) {

  echo "<h2>Discover</h2>";
  //$result = queryMysql("SELECT * FROM members where user!='$user' ORDER BY RAND() LIMIT 5");
  $result = queryMysql("SELECT * FROM members where user!='$user' LIMIT 3");
  $following = array();
  $num    = $result->num_rows;
  for ($j = 0 ; $j < $num ; ++$j) {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['user'];
  }
  echo "<div class='discoverBack'>";
  foreach($following as $friend){
    $name = "$friend";
    echo "<div class='discoverBox'>";
    echo "<div class='discoverInfo'>";
    echo "<h5><a href='members.php?view=$name'>$name</a></h5>";
    if (file_exists("userpics/$friend.jpg"))
        echo "<img class='discoverPic' src='userpics/$friend.jpg'>";
    echo "<div class='discoverSongbox'>";
    foreach(glob("useraudio/$friend*.mp3") as $file){
      $shortName = explode(".", basename($file));
      echo "<div style='display: inline-block;'>";
      echo ("<p style='float: left; padding-right: 2em;'><b>$shortName[1]</b></p>");
      if (file_exists($file)){
        echo "
        <audio controls style='float: left; padding-right: 2em;'>
          <source src='$file' type='audio/mp3'>
          Your browser does not support the audio element.
        </audio>
        ";
      }
      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<br>";
  }
   echo "</div>";






}


function searchProfile($user) {

  echo "<h2>Search Results</h2>";
  //$result = queryMysql("SELECT * FROM members where user!='$user' ORDER BY RAND() LIMIT 5");
  $result = queryMysql("SELECT * FROM members where user LIKE '%$user%' LIMIT 3");
  $following = array();
  $num    = $result->num_rows;
  for ($j = 0 ; $j < $num ; ++$j) {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['user'];
  }
  echo "<div class='discoverBack'>";
  foreach($following as $friend){
    $name = "$friend";
    echo "<div class='discoverBox'>";
    echo "<div class='discoverInfo'>";
    echo "<h5><a href='members.php?view=$name'>$name</a></h5>";
    if (file_exists("userpics/$friend.jpg"))
        echo "<img class='discoverPic' src='userpics/$friend.jpg'>";
    echo "<div class='discoverSongbox'>";
    foreach(glob("useraudio/$friend*.mp3") as $file){
      $shortName = explode(".", basename($file));
      echo "<div style='display: inline-block;'>";
      echo ("<p style='float: left; padding-right: 2em;'><b>$shortName[1]</b></p>");
      if (file_exists($file)){
        echo "
        <audio controls style='float: left; padding-right: 2em;'>
          <source src='$file' type='audio/mp3'>
          Your browser does not support the audio element.
        </audio>
        ";
      }
      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<br>";
  }
   echo "</div>";






}


?>
