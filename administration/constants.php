<?php
const user='alexiy_ov';
const password='mislete3nash';
const host='127.0.0.1';
const database='knowledge_base';
const driver='mysql';
/**User name*/
const IDENTIFIER='identifier';
const PASSSWORD='password';
const EMAIL='email';
const USERS='user_data';
const TOPICS='topic_data';
const DEFAULT_GROUP='readers';
const ADMINISTRATOR_GROUP='overseers';
const USER_NAME_LENGTH=32;
const DEFAULT_CATEGORY='General';
const GROUP='group';
const USER='current_user';
const COMMENT_TABLE_PREFIX='comments_topic_';
const ALLOWED_HTML_TAGS='b,i,p,u,span,div,br,table,th,tr,td,img,iframe,a,ul,li,ol,audio,source,h1,h2,h3,h4,kbd,code,pre,style,sub,sup';
/**Content used in editor*/
const SAVED_CONTENT='savedContent';
///** Intializes a local connection with mysql database
// * @param string $database
// * @return PDO
// */
//function defaultConnection($database=database)
//{
//    $pdo= new PDO(driver.":dbname=".$database.';host=127.0.0.1',user,password);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//    return $pdo;
//}


function defaultMysqlConnection($database=database)
{
    $mysqlcon=new mysqli(host,user,password,$database);
    if($mysqlcon->connect_error)
    {
        echo $mysqlcon->connect_errno."\n";
        $mysqlcon->close();
    }
    return $mysqlcon;
}
