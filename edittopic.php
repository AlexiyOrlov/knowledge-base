<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editing topic</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<script src="static/jquery-3.3.1.js"></script>
<script src="static/scripts.js"></script>

<?php
include_once "functions.php";
session_start();
$user=getUserFromSession($_SESSION);
if($user) {
    $tpid = $_GET['id'];
    $getTopic = "SELECT * FROM knowledge_base.topic_data WHERE `index`=$tpid";
    $ohmy = defaultMysqlConnection();
    $rows=executeQuery($ohmy,$getTopic, true);
    $title=$rows[0]['title'];
    $content=$rows[0]['content'];
    $category=$rows[0]['category'];
    echo "<form method='post' action='changetopic.php' onsubmit='return checkContent()'>";
    echo "<h1>$title</h1>";
    //echo "<ul class='list-no-markers'>";
    echo  "<input class='title' size='100' name='title' title='Title' maxlength='128' value='$title'>
            <select name='category' title='Category'>";
    $request="SELECT category FROM knowledge_base.topic_data";
    $results=executeQuery($ohmy,$request);
    if($results)
    {
        $categoryarray=array();
        array_push($categoryarray,$category);
        foreach ($results as $r)
        {
            array_push($categoryarray,$r[0]);

        }
        $categoryarray=array_unique($categoryarray);
        foreach ($categoryarray as $categ)
        {
            echo "<option>$categ</option>";
        }
    }

    echo "</select>";
    echo "<input type='text' title='New category' name='custom_category'>";
    echo "<input name='topic_id' value='$tpid' hidden>";
    $content=htmlentities($content); //here, correct
    $_SESSION[SAVED_CONTENT]=$content;
    include_once "texteditor.php";
    echo "<input type=submit value='Change'></form>";
    echo "<label id='errors'></label>";
    $ohmy->close();
}
else echo "You aren't logged in";
?>
<script>
    function checkContent() {
        let label =document.getElementById("errors");

        let textarea=document.getElementsByTagName("textarea")[0];
        //get the 'value' !
        let text=textarea.value;
        if(hasBadWords(text))
        {
            label.innerHTML="Swearing is not allowed here";
            return false;
        }
        let forbiddentag=hasForbiddenTags(text,0);
        if(forbiddentag)
        {
            label.innerHTML="Detected forbidden tag";
            return false;
        }
        return true;
    }
</script>
</body>
</html>
