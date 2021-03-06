<?php
session_start();
require_once 'header.php';

echo "<h3>Welcome to $clubstr. </h3>";
echo "<div>";

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else $loggedin = false;

if ($loggedin) {
    echo <<<_LOGGEDIN
        $user, you are logged in
_LOGGEDIN;
}
else {
    echo <<<_GUEST
        <h4>The music collaboration software designed to combine creativity</h4>
        <h4>Please sign up, or log in if you're already a member.</h4>
_GUEST;
}
showDiscover($view);
echo <<<_END
    </div><br>
_END;

require_once 'footer.php';
?>
