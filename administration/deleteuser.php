<?php
include_once "../functions.php";
$uid=$_POST['identifier'];
if($uid)
{
    $mysql=defaultMysqlConnection();
    if($mysql)
    {
        $deletion="DELETE FROM knowledge_base.user_data WHERE identifier='$uid'";
        $result=executeQuery($mysql,$deletion);
        if(!$result) echo "Deleted user $uid";
        else echo false;
        $mysql->close();
    }
}
