<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>

<script>
    function deleteUser(button) {
        let name=button.getAttribute('data-id');
        if(name) {
            let confirmed = confirm("Delete user " + name + "?")
            if (confirmed) {
                let request = new XMLHttpRequest()
                request.onreadystatechange = function () {
                    if (request.readyState === 4) {
                        window.location.reload()
                        console.log(request.responseText)
                        if(!request.responseText)
                            alert("Couldn't delete the user")
                    }
                }
                request.open('POST', 'deleteuser.php', true)
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                request.send('identifier=' + name)
            }
        }
    }
    
    function editDialog(button) {
        let userid=button.getAttribute('data-id')
        let usermail=button.getAttribute('data-mail')
        let group=button.getAttribute('data-group')
        let state=button.getAttribute('data-status')
        let dialog=document.getElementById('edit-dialog')
        if(dialog.hasAttribute('hidden'))
            dialog.removeAttribute('hidden')
        else dialog.setAttribute('hidden','')
        let inputs=dialog.getElementsByTagName('input')
        inputs[0].value=userid
        inputs[1].value=usermail
        let togglebutton=dialog.getElementsByTagName('button')[0]
        togglebutton.innerHTML=state;
        togglebutton.onclick=function () {
            if(togglebutton.innerHTML==1) togglebutton.innerHTML=0
            else togglebutton.innerHTML=1;
        }
        let groupselction=document.getElementById('group')

        let applyButton=document.getElementById('apply-changes')
        applyButton.onclick=function () {
            if(inputs[0].value && inputs[1].value) {
                let xrequest = new XMLHttpRequest();
                xrequest.onreadystatechange = function () {
                    if (xrequest.readyState === 4) {
                        window.location.reload()
                        console.log(xrequest.responseText)
                    }
                };
                xrequest.open('POST', 'modifyuser.php', true)
                xrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                xrequest.send('user=' + inputs[0].value + '&mail=' + inputs[1].value + '&group=' + groupselction.value + '&status=' + togglebutton.innerHTML+'&currentname='+userid)
            }
            else alert('All fields must be filled')
        }
    }
</script>
<?php
include_once "../functions.php";
include_once  "menu.php";
$ohmy=defaultMysqlConnection();
$getAllUsers="SELECT * FROM knowledge_base.user_data";
$data=executeQuery($ohmy,$getAllUsers);
if($data)
{
    session_start();
    $user=getUserFromSession($_SESSION);
    $group=null;
    if($user)
    {
        $group=$user->getGroup();
    }
    echo "<table><tr><th>Identifier</th><th>Group</th><th>E-mail</th><th>Status</th></tr>";
    foreach ($data as $array)
    {
        echo "<tr><td>$array[0]<td>$array[2]</td><td>$array[1]</td><td>$array[4]</td>";
        if($group===ADMINISTRATOR_GROUP)
        {
            echo "<td><button data-id='$array[0]' data-mail='$array[1]' data-group='$array[2]' data-status='$array[4]' onclick='editDialog(this)'>Edit</button><td><button data-id='$array[0]' onclick='deleteUser(this)'>Delete</button></td></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    $getgroups="SELECT id,name FROM knowledge_base.group_data";
    $res=executeQuery($ohmy,$getgroups);
    if($res)
    {
        echo "<span id='edit-dialog' hidden>
                <input id='id' title='Identifier'>
                <input id='email' title='Email address'> 
                <select id='group' title='Group'>";
        foreach ($res as $item)
        {
            echo "<option>$item[1]</option>";
        }
        echo "</select>
            <button id='user-status' data-id='$array[0]'>$array[4]</button>
            <button id='apply-changes'>Apply</button>
            </span>";
    }
}
else{
    echo "No data available";
}
$ohmy->close();
?>
</body>
