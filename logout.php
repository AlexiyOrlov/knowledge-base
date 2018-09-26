<!DOCTYPE html>
<html>
<head>
    <title>Log out</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
session_start();
$_SESSION=array();
session_destroy();
if(session_status()==PHP_SESSION_NONE || session_status()==PHP_SESSION_DISABLED)
{
    echo "You logged out successfully<br>";
}
else echo session_status();
echo "<a href='index.php'>Back to main page</a>";
?>
</body>
