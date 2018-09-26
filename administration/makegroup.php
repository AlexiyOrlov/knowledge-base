<!DOCTYPE html>
<html>
<head>
    <title>New group</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
<?php
include_once "../functions.php";
session_start();
$user=getUserFromSession($_SESSION);
if($user)
{
    $name=$_POST['name'];
    $cantoggleusers=$_POST['deactivateUsers'];
    $candeleteusers=$_POST['deleteUsers'];
    $candeletegroups=$_POST['deleteGroups'];

    $cancreategroups=$_POST['createGroups'];
    $cancomment=$_POST['comment'];
    $cancreatetopics=$_POST['createTopics'];

    $caneditcomments=$_POST['editComments'];
    $canedittopics=$_POST['editTopics'];
    $candeletecomments=$_POST['deleteComments'];
    $candeletetopics=$_POST['deleteTopics'];


    $cantoggleusers=convertCheckboxState($cantoggleusers);
    $candeleteusers=convertCheckboxState($candeleteusers);
    $candeletegroups=convertCheckboxState($candeletegroups);
    $cancreategroups=convertCheckboxState($cancreategroups);
    $cancomment=convertCheckboxState($cancomment);
    $cancreatetopics=convertCheckboxState($cancreatetopics);
    $caneditcomments=convertCheckboxState($caneditcomments);
    $canedittopics=convertCheckboxState($canedittopics);
    $candeletecomments=convertCheckboxState($candeletecomments);
    $candeletetopics=convertCheckboxState($candeletetopics);

    //TODO reject duplicate name
    $creategroup="INSERT INTO knowledge_base.group_data VALUES (DEFAULT ,'$name', $candeletetopics, $candeletecomments,$canedittopics, $caneditcomments, $cancreatetopics,
      $cancomment, $cancreategroups, $candeletegroups, $candeleteusers, $cantoggleusers)";

    $ohmy=defaultMysqlConnection();
    if($ohmy)
    {
        $result=executeQuery($ohmy,$creategroup);
        if(!$result)
        {
            echo "Created group '$name' successfully'\n";
        }
        else{
             var_dump($result);
        }

    }
    $ohmy->close();
}
else{
    include_once "../navigation.php";
}
?>
</body>
