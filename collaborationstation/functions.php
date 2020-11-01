<?php
$dbhost  = 'localhost';

$dbname  = 'db35';   // Modify these...
$dbuser  = 'user35';   // ...variables according
$dbpass  = '35fils';   // ...to your installation


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
  else echo "<p>No Profile Photo</p><br>";

  //Code that shows user's uploaded songs
    foreach(glob("useraudio/$user*.mp3") as $file){
      $shortName = explode(".", basename($file));
      echo "<div style='display: inline-block; overflow:scroll;>";
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

function showDiscover() {

  echo "<h2>Discover</h2>";
  $result = queryMysql("SELECT * FROM members ORDER BY RAND() LIMIT 5");
  $following = array();
  $num    = $result->num_rows;
  for ($j = 0 ; $j < $num ; ++$j) {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['user'];
  }
  echo "<div style='width= 20vw; display: block; background-color: Gainsboro; margin= 2em;'>";
  foreach($following as $friend){
    $name = "$friend";
    echo "<div style='display: inline-block; overflow:scroll;'>";
    echo "<div style='display: inline-block; margin: 2em;'>";
    echo "<h3>$name</h3>";
    if (file_exists("userpics/$friend.jpg"))
        echo "<img class='userpic' style='text-align: left; position: absolute; margin: 2em;' src='userpics/$friend.jpg'>";
    echo "<div style=' box-shadow: 5px 10px; border: 1px solid black; text-align: right; padding: 2em;'>";
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
