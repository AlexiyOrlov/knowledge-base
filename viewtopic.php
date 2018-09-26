<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="static/styles.css">
    <link rel="stylesheet" href="static/prism.css"
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php
    include_once "functions.php";
    include_once "navigation.php";
    $topicIndex=$_GET['id'];
    $ohmy=defaultMysqlConnection();
    $getTopic="SELECT * FROM knowledge_base.topic_data WHERE `index`=$topicIndex";
    $result=executeQuery($ohmy,$getTopic);
    if($result)
    {
        $title=$result[0][3];
        $content=$result[0][5];
        echo "<title>$title</title>";
        $shortDescription=substr(htmlToRawText($content),0,200); //check for errors
        echo "<meta name='description' content='$shortDescription'>";
    }
    ?>
</head>
<body>
<script src="static/jquery-3.3.1.js"></script>
<script src="static/prism.js"></script>
<script src="static/scripts.js"></script>
<script>

    function checkComment() {
        let label=document.getElementById('errors');
        let comment=document.getElementsByName('comment')[0];
        let text=comment.value;
        if(hasBadWords(text))
        {
            label.innerHTML="Swearing is not allowed here";
            return false;
        }
        if(hasForbiddenTags(text,0))
        {
            label.innerHTML="Found forbidden tag";
            return false;
        }
        return true;
    }

    function toggleCommentForm() {
        let form=document.getElementsByTagName('form')[0]
        form.hidden=!form.hidden;
    }
</script>

<?php
session_start();

if($result)
{
    $canDeleteComments;
    $canEdit;
    $name;
    $user=getUserFromSession($_SESSION);
    if($user)
    {

        $name=$user->getName();
        $group=$user->getGroup();
        $getPermissions="SELECT * FROM knowledge_base.group_data WHERE name='$group'";
        $res=executeQuery($ohmy,$getPermissions, true);
        if($res) {
            $canDeleteComments = $res[0]['can_delete_comments'];
            $canEdit = $res[0]['can_edit_topics'];
        }
    }



    $author=$result[0][2];
    $date=$result[0][4];
    $category=$result[0][1];

    echo "<h2 class='cool-color'>$title</h2>";
    echo "<h3>by <span class='name'> $author</span></h3>";
    echo "<h4>on $date</h4>";

    echo "<article class='content'>$content</article><br>";
    if($canEdit OR $author==$name)
    {
        echo "<a href='edittopic.php?id=$topicIndex'>Edit this topic</a>";
    }

    //comments:
    $commentable=COMMENT_TABLE_PREFIX.$topicIndex;
    $checktable="SHOW TABLES LIKE '$commentable'";
    $reteieve=executeQuery($ohmy,$checktable);
    if($reteieve)
    {
        $getcomments="SELECT * FROM knowledge_base.$commentable";
        $resultat=executeQuery($ohmy,$getcomments);
        if($resultat)
        {

            foreach ($resultat as $array)
            {
                echo "<span><pre class='content'>$array[3]</pre><p>by $array[1] on $array[2]";
                if($canDeleteComments) echo "<a href='deletecomment.php?cid=$array[0]&topicid=$topicIndex'>Delete this comment</a>";
                   echo"</p></span>";
            }
        }
        echo "<br>";
    }
    else echo "<h3 class='cool-color'>No comments</h3>";
    if($user)
    {

        echo "<button onclick='toggleCommentForm()'>Leave comment</button>
            <form method='post' action='addcomment.php' onsubmit='return checkComment()' hidden> 
                <textarea name='comment' placeholder='Comment' cols='100' rows='10' maxlength='1000' required></textarea><br>
                <input type='submit' value='Submit'><br>
                <input name='topic_id' value='$topicIndex' hidden required>
                <input name='commenter' value='$name' hidden required>
            </form>
            <label id='errors'></label>";

    }
}
$ohmy->close();
//var_dump(htmlToRawText($content));
?>
</body>
