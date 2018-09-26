<!DOCTYPE html>
<html>
<head>
    <title>Knowledge Base Topics</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A place to start exploring various topics from">
</head>
<body>
<script src="static/scripts.js"></script>
<?php
include_once "functions.php";
include_once "navigation.php";
include_once "utilities/Set.php";
    session_start();
    $user=getUserFromSession($_SESSION);

    $loggedin=isset($user);

    $createTopicTable="CREATE TABLE IF NOT EXISTS knowledge_base.topic_data
        (
            `index` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            category VARCHAR(30) DEFAULT 'General' NOT NULL,
            creator VARCHAR(32) NOT NULL,
            title VARCHAR(64) NOT NULL,
            date_created DATETIME DEFAULT NOW() NOT NULL,
            content MEDIUMTEXT NOT NULL
        )";
    //echo "2";
    $connection=defaultMysqlConnection();
    //echo $createTopicTable;
    $result=executeQuery($connection,$createTopicTable);

    $fetchCategories="SELECT category, `index` FROM knowledge_base.topic_data ORDER BY category";
    $categories=executeQuery($connection,$fetchCategories);
    if($categories)
    {
        echo "<h1>Categories</h1>";
        $name=array();
        foreach ($categories as $category)
        {
            array_push($name,$category[0]);
        }
        $nameset=new \alexiy\Set($name);
        echo "<ul>";
        foreach($nameset->array as $value)
        {
            echo "<li><a href='viewcategory.php?name=$value' </a>$value</li>";
        }

        echo "</ul>";
    }
    else{
        echo "<h3>There are no topics</h3>";
    }

    if($loggedin)
    {
        $group=$user->getGroup();
        $cancreateTopics="SELECT can_create_topics FROM knowledge_base.group_data WHERE name='$group'";
        $res=executeQuery($connection,$cancreateTopics);
        if($res[0]==true)
            echo "<a href='createtopic.php'>Create a topic</a>";
    }
    $connection->close();
?>
</body>
