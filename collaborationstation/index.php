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
        <h5>Please sign up, or log in if you're already a member.</h5>
_GUEST;
}

echo <<<_END
    </div><br>
_END;

require_once 'footer.php';
?>