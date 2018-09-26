<!DOCTYPE html>
<html>
<head>
    <title>Groups</title>
<link rel="stylesheet" href="../static/styles.css">
</head>
<body>
<script src="../static/jquery-3.3.1.js"></script>
<script src="../static/scripts.js"></script>
<script>
    function toggleGroupForm() {
        $('#group-edit').hide()
        //let forms=document.getElementsByTagName("form")
        //forms[0].hidden=false
        $('#make-group').show()
    }

    function toggleEditForm(button) {

        $('#make-group').hide()

        let name=button.getAttribute('data-name')
        let deletetopics=button.getAttribute('data-delete-topics')
        let deletecomments=button.getAttribute('data-delete-comments')
        let edittopics=button.getAttribute('data-edit-topics')
        let editcomments=button.getAttribute('data-edit-comments')
        let createtopics=button.getAttribute('data-create-topics')
        let comment=button.getAttribute('data-comment')
        let creategroups=button.getAttribute('data-create-groups')
        let deletegroups=button.getAttribute('data-delete-groups')
        let deleteusers=button.getAttribute('data-delete-users')
        let toggleusers=button.getAttribute('data-can-deactivate')

        $('#group-edit').children('input')[0].value=name
        let checkboxes=$('#group-edit').children('ul').children('li').children('input')
        checkboxes.prop('checked','')

        if(deletetopics==='1') checkboxes[0].click()
        if(deletecomments==='1') checkboxes[1].click()
        if(edittopics==='1') checkboxes[2].click()
        if(editcomments==='1') checkboxes[3].click()
        if(createtopics==='1') checkboxes[4].click()
        if(comment==='1') checkboxes[5].click()
        if(creategroups==='1') checkboxes[6].click()
        if(deletegroups==='1') checkboxes[7].click()
        if(toggleusers==='1') checkboxes[8].click()
        if(deleteusers==='1') checkboxes[9].click()
        //console.log(deleteusers)
        $('#group-edit').show()
    }


</script>
<?php
include_once "../functions.php";
include_once "menu.php";
session_start();
$user=getUserFromSession($_SESSION);
if($user)
{
    $dtconn=defaultMysqlConnection();
    //$createGroupPermissionTable=
    $createGroupTable="create table IF NOT EXISTS knowledge_base.group_data
    (
    id int auto_increment
		primary key,
	name varchar(30) not null,
	can_delete_topics tinyint(1) default '0' not null,
	can_delete_comments tinyint(1) default '0' not null,
	can_edit_topics tinyint(1) default '0' null,
	can_edit_comments tinyint(1) default '0' null,
	can_create_topics tinyint(1) default '1' not null,
	can_comment tinyint(1) default '1' not null,
	can_create_groups tinyint(1) default '0' not null,
	can_delete_groups tinyint(1) default '0' not null,
	can_delete_users tinyint(1) default '0' not null,
	can_deactivate_users tinyint(1) default '0' not null,
	constraint group_data_name_uindex
		unique (name)
    )
    comment 'table for managing permissions'";

    executeQuery($dtconn,$createGroupTable);

    $group=$user->getGroup();
    if($group===ADMINISTRATOR_GROUP)
    {
        $selectPermissions="SELECT name,can_delete_topics, can_delete_comments,can_edit_topics, can_edit_comments,can_create_topics,can_comment,
        can_create_groups,can_delete_groups,can_delete_users,can_deactivate_users FROM knowledge_base.group_data";
        $rows=executeQuery($dtconn,$selectPermissions);
        if($rows)
        {
            echo "<table><tr><th>Name</th><th>Can delete topics</th><th>Can delete comments</th><th>Can edit topics</th><th>Can edit comments</th>
                <th>Can create topics</th><th>Can comment</th><th>Can create groups</th><th>Can delete groups</th><th>Can delete users</th>
                <th>Can toggle users</th></tr>";
            foreach ($rows as $r)
            {
                $name=$r[0];
                $canDeleteTopics=$r[1];
                $canDeleteComments=$r[2];
                $canEditTopics=$r[3];
                $canEditComments=$r[4];
                $canCreateTopics=$r[5];
                $canComment=$r[6];
                $canCreateGroups=$r[7];
                $canDeleteGroups=$r[8];
                $canDeleteUsers=$r[9];
                $canDeactivateUsers=$r[10];

                echo "<tr><td>$name</td><td>$canDeleteTopics</td><td>$canDeleteComments</td><td>$canEditTopics</td><td>$canEditComments</td><td>$canCreateTopics</td>
                    <td>$canComment</td><td>$canCreateGroups</td><td>$canDeleteGroups</td><td>$canDeleteUsers</td><td>$canDeactivateUsers</td>";
                if($name!=ADMINISTRATOR_GROUP) {
                    echo "<td><button onclick='toggleEditForm(this)' data-name=$name data-delete-topics=$canDeleteTopics data-delete-comments=$canDeleteComments data-edit-topics=$canEditTopics
                        data-edit-comments=$canEditComments data-create-topics=$canCreateTopics data-comment=$canComment data-create-groups=$canCreateGroups
                        data-delete-groups=$canDeleteGroups data-delete-users=$canDeleteUsers data-can-deactivate=$canDeactivateUsers>Edit</button></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

        }

        echo "<button onclick='toggleGroupForm()'>Create new group</button>";
        echo "<form method='post' action='makegroup.php' id='make-group' hidden>
                
                <input type='text' name='name' pattern='[A-z_0-9 ]+' placeholder='Group name' required>
                <ol>
                    <li><label>Can toggle users?</label><input type='checkbox' name='deactivateUsers'></li>
                    <li><label>Can delete users?</label><input type='checkbox' name='deleteUsers'></li>
                    <li><label>Can delete groups?</label><input type='checkbox' name='deleteGroups'></li>
                    <li><label> Can create groups?</label><input type='checkbox' name='createGroups'></li>
                    <li><label>Can comment?</label><input type='checkbox' name='comment'></li>
                    <li><label>Can create topics?</label><input type='checkbox' name='createTopics'></li>
                    <li><label>Can edit comments?</label><input type='checkbox' name='editComments'></li>
                    <li><label>Can edit topics?</label><input type='checkbox' name='editTopics'></li>
                    <li><label>Can delete comments?</label><input type='checkbox' name='deleteComments'></li>
                    <li><label>Can delete topics?</label><input type='checkbox' name='deleteTopics'></li>
                </ol>
                
                
                <input type='submit' value='Create'>
                
            </form>";

        echo "<form method='post' action='modifygroup.php' id='group-edit' hidden>
                <input name='name' title='Name' pattern='[A-z_0-9 ]+' required>
                <ul>
                    <li><input type='checkbox'  name='deleteTopics'>Can delete topics</li>
                    <li><input type='checkbox'  name='deleteComments'>Can delete comments</li>
                    <li><input type='checkbox'  name='editTopics'>Can edit topics</li>
                    <li><input type='checkbox'  name='editComments'>Can edit comments</li>
                    <li><input type='checkbox'  name='createTopics'>Can create topics</li>
                    <li><input type='checkbox'  name='canComment'>Can comment</li>
                    <li><input type='checkbox'  name='createGroups'>Can create groups</li>
                    <li><input type='checkbox'  name='deleteGroups'>Can delete groups</li>
                    <li><input type='checkbox'  name='deactivateUsers'>Can deactivate users</li>
                    <li><input type='checkbox'  name='deleteUsers'>Can delete users</li>
                    
                </ul>
                <input type='submit' value='Modify'>
               </form>";
    }
    $dtconn->close();

}




?>
</body>
