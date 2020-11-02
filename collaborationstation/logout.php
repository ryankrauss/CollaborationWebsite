<?php
require_once 'header.php';

if (isset($_SESSION['user'])) {
    destroySession();
    echo "<script>window.location = 'index.php?view=$user'</script>";
}
else 
    echo "<div class='center'>You can't log out because you're not logged in</div>";

require_once 'footer.php';
?>
