<!DOCTYPE html>
<html>
<head>
    <title>Topic validation</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once "functions.php";
include_once "navigation.php";
session_start();
$currentuser=getUserFromSession($_SESSION);
$title=$_POST['title'];
$content=$_POST['content'];
$category=$_POST['category'];
$customcategory=$_POST['customCategory'];
if($customcategory) $category=$customcategory;
$ohMy=defaultMysqlConnection();

$_SESSION['cachedTitle']=$title;
$_SESSION['cachedCategory']=$category;
$_SESSION['cachedContent']=$content;
$_SESSION[SAVED_CONTENT]=htmlentities($content); //TODO check
if(!$currentuser)
{
    echo "You are not logged in, or the session has expired\n";
}
elseif(!$title)
{
    echo "A title is required\n";
}
elseif (!$content)
{
    echo "Content is required\n";
}
else {
    $user=$currentuser->getName();
    $query = "SELECT title FROM knowledge_base.topic_data WHERE  title='$title'";
    $a = executeQuery($ohMy, $query);
    if ($a) {
        echo "A topic with such title exists. Make a different title\n";
    } else {
        $content=mysqli_real_escape_string($ohMy,$content);
        $insert = "INSERT INTO knowledge_base.topic_data VALUES (DEFAULT ,'$category' , '$user', '$title', DEFAULT  ,'$content')";
        $res = executeQuery($ohMy, $insert);
        if (!$res) {
            {
                unset($_SESSION[SAVED_CONTENT]);
                echo "Created topic '$title' in category '$category'\n";
                unset($_SESSION['cachedTitle']);
                unset($_SESSION['cachedCategory']);
                unset($_SESSION['cachedContent']);
            }
        } else {
            echo "Failed to create a topic\n";
        }
    }
}
$ohMy->close();
?>
</body>
