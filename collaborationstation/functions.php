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

  //Code that shows user's uploaded songs
    foreach(glob("useraudio/$user*.mp3") as $file){
      $shortName = explode(".", basename($file));
      echo ("<p>$shortName[1]</p>");
      if (file_exists($file)){
        echo "
        <audio controls>
          <source src='$file' type='audio/mp3'>
          Your browser does not support the audio element.
        </audio>
        ";
      }
    }

    if (file_exists("userpics/$user.jpg"))
        echo "<img class='userpic' src='userpics/$user.jpg'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
    else echo "<p>Nothing to see here, yet</p><br>";
}
?>
