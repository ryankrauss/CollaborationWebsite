<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'Not all fields were entered';
    else {
        $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

        if ($result->num_rows == 0) {
            $error = "Invalid login attempt";
        }
        else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            echo "<script>window.location = 'index.php?view=$user'</script>";
        }
    }
}

echo <<<_END

    <form method='post' action='login.php'>
        <div data-role='fieldcontain'>
            <label></label>
            <span class='error'>$error</span>
        </div>
        <div data-role='fieldcontain'>
            <label></label>
            <h3>Enter username and password</h3>
        </div>
        <div data-role='fieldcontain'>
            <label id = "userEnter">Username</label>
            <input type='text' maxlength='16' name='user' value='$user'>
        </div>
        <div data-role='fieldcontain'>
            <label id = "userEnter">Password</label>
            <input type='password' maxlength='16' name='pass' value='$pass'>
        </div>
        <div data-role='fieldcontain'>
            <label></label>
            <input data-transition='slide' type='submit' value='Login'>
        </div>
    </form>
_END;
require_once 'footer.php';
?>
