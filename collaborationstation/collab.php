

<?php
session_start();
require_once 'header.php';
require_once 'testpage.php';

echo "<div>";

if(isset($_POST['submit']))
    {

$path = "useraudio/$user.";
$valid_formats1 = array("mp3", "ogg", "flac");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
    {
        $file1 = $_FILES['file1']['name'];
        $size = $_FILES['file1']['size'];

        if(strlen($file1))
            {
                list($txt, $ext) = explode(".", $file1);
                if(in_array($ext,$valid_formats1))
                {
                        $actual_image_name = $txt.".".$ext;
                        $tmp = $_FILES['file1']['tmp_name'];
                        if(move_uploaded_file($tmp, $path.$actual_image_name))
                            {
                            echo "Upload Successful";
                            }
                        else
                            echo "failed";
                    }
        }
    }
}

echo <<<_END
    </div><br>
_END;

if (!$loggedin)
    die("Log in for messages</div><footer></footer></body></html>");

if (isset($_GET['view'])) 
    $view = sanitizeString($_GET['view']);
else 
    $view = $user;

if (isset($_POST['text'])) {
    $text = sanitizeString($_POST['text']);

    if ($text != "") {
        $pm   = substr(sanitizeString($_POST['pm']),0,1);
        $time = time();
        queryMysql("INSERT INTO messages VALUES(NULL, '$user','$view', '$pm', $time, '$text')");
    }
}

if ($view != "") {
    if ($view == $user) 
        $name1 = $name2 = "Your";
    else {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
  }

  echo "<h3>$name1 Messages</h3>";
  // showProfile($view);

  echo <<<_END
  <form method='post' action='messages.php?view=$view'>
    <fieldset data-role="controlgroup" data-type="horizontal">
        <legend>Type here to leave a message</legend>
        <input type='radio' name='pm' id='private' value='1'>
        <label for="private">Private Note</label><br><br>
        <textarea name='text'></textarea><br>
    </fieldset>

    <input data-transition='slide' type='submit' value='Post Message'>
</form><br>
_END;

date_default_timezone_set('UTC');

if (isset($_GET['erase'])) {
    $erase = sanitizeString($_GET['erase']);
    queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
}

$query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
$result = queryMysql($query);
$num    = $result->num_rows;

for ($j = 0 ; $j < $num ; ++$j)
{
  $row = $result->fetch_array(MYSQLI_ASSOC);

  if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user) {
      echo date('M jS \'y g:ia:', $row['time']);
      echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

      if ($row['pm'] == 0)
          echo "wrote a <em>public post</em>:<div>&quot;" . $row['message'] . "&quot; ";
      else
          echo "wrote a <em>private note</em>:<br><div>&quot;" . $row['message']. "&quot; ";

      if ($row['recip'] == $user)
          echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>Delete</a>]";
      echo "</div>";
  }
}
}

if (!$num)
    echo "<br><span class='info'>No messages yet</span><br><br>";

echo "<br><a data-role='button' href='collab.php?view=$view'>Refresh messages</a>";

require_once 'footer.php';

?>

<html>
  <meta charset="UTF-8">
  <title>Upload Example</title>

  <body>


	<form enctype="multipart/form-data" id="form1" method="post" action="collab.php">
	<input type="file" name="file1" accept=".ogg,.flac,.mp3" required="required"/>
	<input type="submit" name="submit"/>
	</form>
  </body>
</html>