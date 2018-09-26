<?php
include_once "../functions.php";
$user=$_POST['currentname'];
$newName=$_POST['user'];
$email=$_POST['mail'];
$group=$_POST['group'];
$state=$_POST['status'];

$my=defaultMysqlConnection();
if($my)
{
    $chageuiser="UPDATE knowledge_base.user_data SET identifier='$newName',email='$email',`group`='$group',activated=$state WHERE identifier='$user'";
    $result=executeQuery($my,$chageuiser);
    //if($result!=null)
    //{
    //    echo "Changed user successfully";
    //}
    $my->close();
}