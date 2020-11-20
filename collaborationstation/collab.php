

<?php
require_once 'header.php';


echo "<div>";


if (!$loggedin)
    die("Log in for messages</div><footer></footer></body></html>");

if (isset($_GET['view']))
    $view = sanitizeString($_GET['view']);
else
    $view = $user;

if ($view != "") {
    if ($view == $user)
        $name1 = $name2 = "Your";
    else {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
  }

  echo "<h3>$name1 Collaborations</h3>";
  // showProfile($view);
  showCollab($view);
  echo <<<_END
_END;

}
echo <<<_END
    </div><br>
_END;
die(require 'footer.php');
?>
