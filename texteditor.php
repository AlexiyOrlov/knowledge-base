<head>
    <link rel="stylesheet" href="static/styles.css">
</head>
<?php
include_once "functions.php";
include_once "utilities/Set.php";
?>
<div class="horizontal">
<textarea oncontextmenu="showMenu(event)" onclick="hidemenu()" id="editor" cols="100" rows="33" maxlength="50000"
          name="content" class="text-input" onkeypress="countRemainingCharaters(event)" required><?php
    echo $_SESSION[SAVED_CONTENT];
    ?></textarea>
    <article class="content" id="preview"></article></div>
<select onclick="insertTags(event,this)" title="HTML tags" id="tags">
    <?php
    $tags = preg_split('/,/', ALLOWED_HTML_TAGS);
    foreach ($tags as $tag) {
        echo "<option>$tag</option>";
    }
    ?>
</select>
<button onclick="preview()" type="button">Preview</button>
<label id="chars-remaining">40000 characters remaining</label>
<canvas hidden></canvas>
<script>


    let canvas=document.getElementsByTagName('canvas')[0]
    let context=canvas.getContext('2d')
    let showPreview=false;
    let showmenu=0;
    function countRemainingCharaters(event) {
        if(event.key==='Insert')
        {
            let selectedTag = document.getElementById('tags')
            let tag = selectedTag.value
            let textarea=document.getElementById('editor')
            let caretstart = textarea.selectionStart
            let before = textarea.value.substr(0, caretstart);
            let after = textarea.value.substr(caretstart, textarea.value.length)
            textarea.value = before + '<' + tag + '></' + tag + '>' + after;
            textarea.selectionStart = caretstart + 2 + tag.length
            textarea.selectionEnd = caretstart + 2 + tag.length
        }
        let textarea=document.getElementById('editor')
        let size=textarea.value.length
        let remaining=40000-size
        document.getElementById('chars-remaining').innerHTML=remaining+' characters remaining'
    }

    function insertAngleBrackets() {
        let textarea=document.getElementById('editor');
        let content=textarea.value;
        let selectionStart=textarea.selectionStart;
        let before=content.substr(0,selectionStart);
        let after=content.substr(selectionStart,content.length);
        textarea.value=before+'&lt;&gt;'+after;
        textarea.selectionStart=selectionStart+4;
        textarea.selectionEnd=selectionStart+4;
        textarea.focus(true)
        hidemenu()
    }

    function showMenu(event) {

        if(showmenu>1) {
            let menu = document.getElementById('menu')
            menu.hidden = false
            let width = context.measureText('Insert angle brackets')
            menu.style.top = event.pageY + 'px'
            let x = event.pageX - width.width * 2
            if (x < 0) x = 0
            menu.style.left = x + 'px'
        }
        showmenu++
    }

    function hidemenu() {
        let menu=document.getElementById('menu')
        menu.hidden=true
        showmenu=0;
    }

    function preview() {
        showPreview=!showPreview
        let article = document.getElementById('preview')
        if(showPreview) {
            let editor = document.getElementById('editor')
            article.innerHTML = editor.value
        }
        else{
            article.innerHTML=''
        }
    }


    function insertTags(mouseEvent, selectionTag) {
        if(mouseEvent.target!==selectionTag)
        {
            let tag=mouseEvent.target.value
            let textinput=document.getElementById('editor')
            let content=textinput.value
            let selectionstart=textinput.selectionStart
            let selectionend=textinput.selectionEnd;
            let before=content.substr(0,selectionstart)
            let middle=content.substr(selectionstart,selectionend-selectionstart)
            let after=content.substr(selectionend,content.length)
            // console.log(before+'+'+middle+'+'+after)
            textinput.value= before + '<' + tag + '>'+middle+'</' + tag + '>' + after
            textinput.selectionStart=selectionstart+2+tag.length+middle.length
            textinput.selectionEnd=textinput.selectionStart
            textinput.focus(true)


        }
    }

    //TODO session status
    // function requestSessionTime(){
    //     let request=new XMLHttpRequest()
    //     request.onreadystatechange=function () {
    //         if(request.readyState===4)
    //         {
    //             console.log(request.responseText)
    //         }
    //     }
    //     request.open('GET', 'status.php', true)
    //     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    //     request.send()
    // }
    // setInterval(requestSessionTime,3000)



</script>
<ul  id="menu" style="position: absolute; list-style-type: none; background-color: #e2e18b;  color:#1c6b22; padding-left: 0" hidden>
    <li onclick="insertAngleBrackets()">Insert angle brackets</li>
</ul>