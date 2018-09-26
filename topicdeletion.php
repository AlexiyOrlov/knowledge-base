<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once "navigation.php";
include_once "functions.php";
session_start();
if(isset($_SESSION[IDENTIFIER]))
{
    $topicid=$_GET['tid'];
    $ohmy=defaultMysqlConnection();
    $rq="DELETE FROM knowledge_base.topic_data WHERE `index`=$topicid";
    $a=executeQuery($ohmy,$rq);
    if($a)
    {
        echo "Failed to delete topic";
    }
    else{
        echo "Deleted";
    }
}
?>
</body>
