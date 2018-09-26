<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Deleting comment</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
<?php
include_once "navigation.php";
include_once "functions.php";
$topicid=$_GET['topicid'];
$commentid=$_GET['cid'];
$ohmy=defaultMysqlConnection();
$tablename=COMMENT_TABLE_PREFIX.$topicid;
$query="DELETE FROM knowledge_base.$tablename WHERE id=$commentid";
//echo $topicid.$commentid."\n";
//echo $query;
$result=executeQuery($ohmy,$query);
if(!$result)
{
    echo "Deleted the comment successfully\n";
    echo "<a href='viewtopic.php?id=$topicid'>Back to topic</a>";
}
else{
    echo "Couldn't delete the comment\n";
}
$ohmy->close();

?>
</body>
</html>
