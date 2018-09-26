<!DOCTYPE html>
<html>
<head>
    <title>Group modification</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>

<?php
include_once '../functions.php';
//var_dump($_POST);
$name=$_POST['name'];

$deleteTopics=convertCheckboxState($_POST['deleteTopics']);
$deleteComments=convertCheckboxState($_POST['deleteComments']);
$editTopics=convertCheckboxState($_POST['editTopics']);
$editComments=convertCheckboxState($_POST['editComments']);
$createTopics=convertCheckboxState($_POST['createTopics']);
$canComment=convertCheckboxState($_POST['canComment']);
$createGroups=convertCheckboxState($_POST['createGroups']);
$deleteGroups=convertCheckboxState($_POST['deleteGroups']);
$deactivateUsers=convertCheckboxState($_POST['deactivateUsers']);
$deleteUsers=convertCheckboxState($_POST['deleteUsers']);

$my=defaultMysqlConnection();
if($my)
{
    $changeGroup="UPDATE knowledge_base.group_data SET can_delete_topics=$deleteTopics, can_delete_comments=$deleteComments, can_edit_topics=$editTopics, 
    can_edit_comments=$editComments, can_create_topics=$createTopics, can_comment=$canComment,can_create_groups=$createGroups, can_delete_groups=$deleteGroups, 
    can_deactivate_users=$deactivateUsers, can_delete_users=$deleteUsers WHERE name='$name'";

    $res=executeQuery($my,$changeGroup);
    if(!$res)
    {
        echo "Modified '$name' successfully";
    }
    else {
        var_dump($res);
    }
}
$my->close();
?>
</body>
