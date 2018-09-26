/**
 * Created by alexiy on 1/23/18.
 */


const badwords=new RegExp('(bitch|fuck|faggot|pussy|vagina|dick|dildo|douche|blow.*job|boner|mother.*fucker|^cum$|cunt|' +
    'cunnilingus|holy (crap|shit)|fag|hoe|rim.job|slut|twat|whore)','i')
const russianBadWords=new RegExp('(сука|блядь|пизд.+|мудак|мандавош.+|долбо.б|ебат.+|ебло|пидарас)','i')
// const allowedhtmltags=new RegExp('<b>|<i>|<p>|<u>|<span>|<div>|<br>|<table>|<th>|<tr>|<td>|<img>|<iframe>|<a>|<ul>|' +
//     '<li>|<ol>|<audio>|<source>|<h1>|<h2>|<h3>|<h4>|<kbd>|<code>|<pre>|<sub>|<sup>','i')
const allowedTagStarts=new RegExp('<b|<i|<p|<u|<span|<div|<br|<table|<th|<tr|<td|<img|<iframe|<a|<ul|' +
    '<li|<ol|<audio|<source|<h1|<h2|<h3|<h4|<kbd|<code|<pre|<style|<video|<sup|<sub');
const tag=/<[A-z]+>/;
const menu="<ul style='display: none; position: absolute'>" +
            "<li>Insert angle brackets</li>" +
            "</ul>";

function showCustomMenu(event) {

}

function insertAngleBrackets() {

}

/**
 * An AJAX callback. Reloads the page after response
 * @param target request handler file
 * @param parameters string of parameters
 */
function xhrequest(target,parameters) {
    let request=new XMLHttpRequest();
    request.onreadystatechange=function () {
        if(request.readyState===4)
        {
            window.location.reload();
            console.log(request.responseText)
        }
        request.open('POST',target,true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(parameters)
    }
}

function hasBadWords(text) {
    let found=text.search(badwords)
    let foundRussian=text.search(russianBadWords)
    if(foundRussian!==-1) console.log(text.substr(foundRussian,10))
    return found !== -1 || foundRussian!==-1;

}


function hasForbiddenTags(text,start) {

   if(start<=text.length) {
       text=text.substr(start,text.length)
       let startindex = text.indexOf('<')
       let end = text.indexOf('>')
       if (startindex !== -1 && end !== -1) {
           let tag = text.substr(startindex, end + 1)
           // console.log(tag);


           let tagstarts=allowedTagStarts.source.split('|')
           for(let s in tagstarts)
           {
               let allowedstart=tagstarts[s];
               //TODO extract first condition
               if(tag.startsWith('</') || tag.startsWith(allowedstart))
               {
                   startindex = end + 1;
                   //     //recur
                   if(start>10000) {
                       console.log('Stopped recursion')
                       return true;
                   }
                   return hasForbiddenTags(text, startindex)
               }
           }

            // console.log('Column '+startindex);
           return true;
       }
   }
    return false;
}

function toggleContents(element) {
    let ds=element.getAttribute('hidden')
    if(ds)
    {
        console.log(1)
    }
    else {
        console.log(2)
    }
    console.log(ds);
}
/**
 * @param event
 * @param selectionId id of the 'select' tag
 * @param textarea a text area to insert into
 */
function handleTagInsertion(event, selectionId,textarea) {
    // console.log(event.which)
    if (event.which === 45) //'Insert' key
    {
        let selectedTag = document.getElementById(selectionId)
        let tag = selectedTag.value
        let caretstart = textarea.selectionStart
        let before = textarea.value.substr(0, caretstart);
        let after = textarea.value.substr(caretstart, textarea.value.length)
        textarea.value = before + '<' + tag + '></' + tag + '>' + after;
        textarea.selectionStart = caretstart + 2 + tag.length
        textarea.selectionEnd = caretstart + 2 + tag.length
    }
}
/**
 *
 * @param event
 * @param targetAreaName
 * @param selectionElement
 * @returns {boolean} true if an option was clicked, false if the select tag was clicked
 */
function insertSelectedTag(event, targetAreaName, selectionElement) {
    if(event.target!==selectionElement)
    {

        let tag=event.target.value;
        let textarea=document.getElementsByClassName(targetAreaName)[0]
        let text=textarea.value
        let caretstart=textarea.selectionStart
        let before=text.substr(0,caretstart)
        let after=text.substr(caretstart,text.length)
        let textual=document.querySelector('#insertion-mode:checked')

        if(textual===null) {
            textarea.value = before + '<' + tag + '></' + tag + '>' + after
            textarea.selectionStart = caretstart + 2 + tag.length
            textarea.selectionEnd = caretstart + 2 + tag.length
        }
        else{
            textarea.value=before+'&lt;'+tag+'&gt;&lt;/'+tag+'&gt;'+after
            textarea.selectionStart=caretstart+8+tag.length
            textarea.selectionEnd=caretstart+8+tag.length
        }

        return true
    }

    return false;

}

/**
 * Inserts a pair of coded angle brackets around the caret
 * @param textarea
 */
function insertSigns(textarea) {

    let text=textarea.value;
    let caretStart=textarea.selectionStart;
    let before=text.substr(0,caretStart);
    let after=text.substr(caretStart,text.length);
    textarea.value=before+'&lt;&gt;'+after;
    textarea.selectionStart=caretStart+4;
    textarea.selectionEnd=caretStart+4
}
