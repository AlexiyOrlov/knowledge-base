<?php
require_once "administration/User.php";
include_once "administration/constants.php";

/**
 * @param mysqli mysqlConnection
 * @param string statement
 * @param bool  $fetchAssociative fetch result as associative arrays?
 * @return array a numeric array of result rows or null
 */
function executeQuery(mysqli $mysqlConnection,string $statement, bool $fetchAssociative=false)
{
    //use only one of those
    //$statement=$mysqlConnection->real_escape_string($statement);
    $result=$mysqlConnection->real_query($statement);


    if($result===false)
    {

        echo $mysqlConnection->error;
        $mysqlConnection->close();
        return null;
    }
    else {
        $res=$mysqlConnection->store_result();
        if($res)
        {
            $rows=$res->fetch_all($fetchAssociative ? MYSQLI_ASSOC : MYSQLI_NUM);
            $res->close();
            return $rows;
        }
        else {
            echo $mysqlConnection->error;
        }
    }
    return null;
}

function getUserFromSession(array $session)
{
    //if (session_status() === PHP_SESSION_ACTIVE)
    //{
        if (isset($session[IDENTIFIER])) {
            $currentuser = new \alexiy\User($session[IDENTIFIER], $session[GROUP], $session[EMAIL]);
            return $currentuser;
        }
    //}
    return null;
}
/**Translates checkbox value for usage in SQL statements*/
function convertCheckboxState($checkboxvalue)
{
    if($checkboxvalue==null) return 0;
    return true;
}

function isDeviceMobile()
{
    return preg_match('/Mobile|Android|BlackBerry/',$_SERVER['HTTP_USER_AGENT']);
}

function htmlToRawText(string $htmlString)
{
    return trim(strip_tags(htmlspecialchars_decode($htmlString)));
}
