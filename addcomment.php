<html>
<head>
    <title>Commenting</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">

</head>
<body>
<?php
include_once "navigation.php";
include_once "functions.php";
$comment=$_POST['comment'];
$topicid=$_POST['topic_id'];
$user=$_POST['commenter'];
$mysql=defaultMysqlConnection();
$tableName="comments_topic_$topicid";
$createCommentTable="CREATE TABLE IF NOT EXISTS knowledge_base.$tableName (`id` INT PRIMARY KEY AUTO_INCREMENT,
  creator VARCHAR(32) NOT NULL , `date` DATETIME DEFAULT NOW() NOT NULL , `value` TEXT NOT NULL )";
executeQuery($mysql,$createCommentTable);
$insertComment="INSERT INTO knowledge_base.$tableName VALUES (DEFAULT ,'$user',DEFAULT ,'$comment')";
$result=executeQuery($mysql,$insertComment);
if(!$result)
{
    echo "Commented successfully\n";
    echo "<a href='viewtopic.php?id=$topicid'>Back to topic</a>";
}
else echo "Failed to comment";
$mysql->close();
?>
</body>
