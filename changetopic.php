<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once "navigation.php";
include_once "functions.php";
$newcontent=$_POST['content'];
$title=$_POST['title'];
$topic=$_POST['topic_id'];
$category=$_POST['category'];
$new_category=$_POST['custom_category'];
if($new_category) $category=$new_category;
$mysqlcon=defaultMysqlConnection();
$newcontent=mysqli_real_escape_string($mysqlcon,$newcontent);
$updatetopic="UPDATE knowledge_base.topic_data SET title='$title',content='$newcontent', category='$category' WHERE `index`=$topic";
$result=executeQuery($mysqlcon,$updatetopic);
if($result!=null)
{
    echo "Couldn't change the topic\n";
}
else{
    unset($_SESSION[SAVED_CONTENT]);
    echo "Changed the topic successfully<br>";
    echo "<a href='viewtopic.php?id=$topic'>Back to topic</a>";
}

$mysqlcon->close();
?>
</body>
</html>
