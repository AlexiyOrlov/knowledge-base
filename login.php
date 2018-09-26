<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once "navigation.php";
include_once "functions.php";
if(isDeviceMobile())
{
    echo "<style>li{padding-bottom: 4mm};</style>";
}
?>
<form action="checkcredentials.php" method="post">
    <ul class="list-no-markers">
        <li><input type="text" placeholder="Identifier" name="identifier" required></li>
        <li><input type="password" name="password" placeholder="Password" required></li>
        <li><input type="submit" value="Log in"></li>
    </ul>
</form>
</body>
