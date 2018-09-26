<html>
<head>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php
        include_once "functions.php";
        include_once "navigation.php";
        $catname=$_GET['name'];
        $title=htmlToRawText($catname);
        echo "<title>$title</title>"
    ?>
</head>
<body>
<?php
$ohmy=defaultMysqlConnection();
$gettopics="SELECT `index`,creator,title,date_created,content FROM knowledge_base.topic_data WHERE `category`='$catname' ORDER BY title";
$result=executeQuery($ohmy,$gettopics);
if($result)
{
    session_start();
    $user=getUserFromSession($_SESSION);

    echo "<h2 class='cool-color'>$catname:</h2>";
    echo "<ol>";
    foreach ($result as $row)
    {
        echo "<li><a href='viewtopic.php?id=$row[0]'>$row[2]</a> by <span class='name'>$row[1]</span> on $row[3]";
        if($user && ($user->getGroup()==ADMINISTRATOR_GROUP))
        {
            echo " <a href='topicdeletion.php?tid=$row[0]' onclick='return confirm(\"Confirm deletion:\")'>Delete</a>";
        }
        echo "</li>";
    }
    echo "</ol>";
    if($user)
    {
        $group=$user->getGroup();
        $cancreateTopics="SELECT can_create_topics FROM knowledge_base.group_data WHERE name='$group'";
        $res=executeQuery($ohmy,$cancreateTopics);
        if($res)
            echo "<a href='createtopic.php?category=$catname'>Create a topic</a>";
    }
}
$ohmy->close();
?>
</body>
