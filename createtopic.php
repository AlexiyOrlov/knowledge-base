<!DOCTYPE html>
<html>
<head>
    <title>Creating topic</title>
    <link rel="stylesheet" href="static/styles.css">
    <link rel="stylesheet" href="static/prism.css"
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<?php
include_once "navigation.php";
include_once "functions.php";
include_once "utilities/Set.php";
session_start();
?>
<script src="static/jquery-3.3.1.js"></script>
<script src="static/prism.js"></script>
<script src="static/scripts.js"></script>

<form method="post" onsubmit="return preCheck()" action="validatetopic.php">
    <div>
        <?php
        $cachedtitle=$_SESSION['cachedTitle'];
        $presetCategory=$_GET['category'];
        echo "<input class='title' type='text' name='title' placeholder='Title' size='60' maxlength='128' value='$cachedtitle' required >";
        ?>
        <select name="category" title="Category">
            <?php
                $mymy=defaultMysqlConnection();
                $request="SELECT category FROM knowledge_base.topic_data";
                $res=executeQuery($mymy,$request);
                if($res)
                {
                    $set=new \alexiy\Set();
                   foreach ($res as $array)
                   {
                       $set->add($array[0]);
                   }
                   if($presetCategory) echo "<option>$presetCategory</option>";
                   foreach ($set->array as $category)
                   {
                       if($presetCategory!=$category)
                        echo "<option>$category</option>";
                   }
                }
                $mymy->close();
            ?>
        </select>
        <?php
            $cachedcategory=$_SESSION['cachedCategory'];

            echo "<input class='title' placeholder='New category' name='customCategory' value='$cachedcategory'> ";

        ?>
    </div>

    <?php

        include_once "texteditor.php";
        ?>

    <div>
        <input type="submit" value="Submit">
        <label id="errors"></label>
    </div>
</form>

<!--place local scripts after external ones-->
<script defer>

    function preCheck() {
        let title=document.getElementsByName('title')[0];

        if(hasBadWords(title.value)) {
            $("#errors").html('Found swearing in title');
            //alerts can be disabled by browser
            alert("You aren't alowed to swear here")
            return false;
        }
        let textarea=document.getElementById('editor');
        if(hasBadWords(textarea.value))
        {
            $("#errors").html('Found swearing in text area');
            return false;
        }

        let hasDangerousTags=hasForbiddenTags(title.value,0)
        if(hasDangerousTags)
        {
            $("#errors").html('The title contains forbidden tag')
            return false;
        }
        let tagInText=hasForbiddenTags(textarea.value,0)
        if(tagInText)
        {
            $("#errors").html('The text contains forbidden tag')
            return false;
        }
        return true;
    }

</script>
</body>
