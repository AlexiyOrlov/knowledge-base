<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php
include_once "functions.php";
if(isDeviceMobile())
{
    echo "<style>li{padding-bottom: 4mm};</style>";
}
?>
<nav>
<ul class="list-no-markers">
    <li> <a href="index.php">Main page</a> </li>
    <li> <a href="login.php">Log in</a> </li>
    <li> <a href="registration.html">Register</a> </li>
    <li> <a href="topics.php">Topics</a> </li>
    <li> <a href="sitesupport.php">Helping this website</a> </li>
    <?php
        session_start();
        if(session_status()===PHP_SESSION_ACTIVE) {
            $user = getUserFromSession($_SESSION);
            if ($user) {
                echo "<li><a href='logout.php'>Log out</a> </li>";
                if ($user->getGroup() === ADMINISTRATOR_GROUP) {
                    echo "<li><a href='administration/menu.php'>Administration</a></li>";
                }
            }
        }
    ?>

</ul>
</nav>
</body>
</html>