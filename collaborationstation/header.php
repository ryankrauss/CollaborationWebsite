<?php
session_start();

$clubstr = 'Soundwave';
$userstr = 'Welcome BRO';

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

require_once 'functions.php';

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else $loggedin = FALSE;

echo <<<_HEADER_OPEN

    <body>
        <div id="wrapper">
        <header id="globalHead">
            <div id='logo'>$clubstr</div>
_HEADER_OPEN;

if ($loggedin) {
echo <<<_LOGGEDIN
            <div class="navbar">
                <li><a href='members.php?view=$user'>Home</a></li>
                <li><a href='friends.php'>Friends</a></li>
                <li><a href='collab.php'>Collab</a></li>
                <li><a href='testpage.php'>Song Upload</a></li>
                <li><a href='feed.php'>Live Feed</a></li>

                <div class="dropdown">
                    <button class="dropbtn">Settings
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <li><a href='members.php'>Members</a></li>
                        <li><a href='profile.php'>Edit Profile</a></li>
                        <li><a href='logout.php'>Log out</a></li>
                    </div>
                </div>
                <!--form method="GET" action="search.php">
                  <div id='button-holder'>
                    <button name="search" value="search"><img src="css/magnifying_glass_icon.png" alt="searchButton"></button>
                    <input type="image" name="search" value="search_value" alt="search" src="css/magnifying_glass_icon.png">
                  </div>
                  <input type="text" class="searchBar" placeholder="Search User..">
                </form-->

                <form id="form" role="search" action="search.php">
                  <input type="search" id="query" name="q"
                   placeholder="Search Users..."
                   aria-label="Search through site content">
                  <button>Search</button>
                </form>

                <!--div class='username'>$userstr</div-->
            </div>
_LOGGEDIN;
} else {
echo <<<_GUEST

            <div class="navbar">
                <li><a href='index.php'>Home</a></li>
                <li><a href='feed.php'>Live Feed</a></li>
                <li><a href='signup.php'>Sign Up</a></li>
                <li><a href='login.php'>Log In</a></li>
            </div>
_GUEST;
 }

echo <<<_HEADER_CLOSE

        </header>
        <div id="content">
_HEADER_CLOSE;

?>
