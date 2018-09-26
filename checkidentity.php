<!DOCTYPE html>
<html>
<head>
    <title>Logging in</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once "functions.php";
include_once 'navigation.php';
$id=$_POST[IDENTIFIER];
$email=$_POST[EMAIL];
$passwordRaw=$_POST[PASSSWORD];
try {
    //creates a table with unique and primary identifier
    $createInitialUserTable="CREATE TABLE IF NOT EXISTS ".database.'.'.USERS." ( identifier VARCHAR(32) PRIMARY KEY NOT NULL,
        email VARCHAR(256) NOT NULL,
        `group` VARCHAR(20) DEFAULT '".DEFAULT_GROUP."' NOT NULL,
        password VARCHAR(256) NOT NULL,
         activated TINYINT(1) DEFAULT 1 NOT NULL
         );";//TODO "CREATE UNIQUE INDEX user_data_identifier_uindex ON ".database.'.'.USERS.' (identifier)';


    $mysqlcon=defaultMysqlConnection();
    executeQuery($mysqlcon,$createInitialUserTable);
    $st="SELECT identifier FROM knowledge_base.user_data WHERE identifier='$id'";

    $resultarray=executeQuery($mysqlcon,$st);

    if($resultarray)
    {
        echo "Username $id is reserved. Choose a different one\n";
    }
    else{

        $passwordHashed=password_hash($passwordRaw,PASSWORD_BCRYPT);
        $createUser="INSERT INTO knowledge_base.user_data VALUES ('$id', '$email','".DEFAULT_GROUP."','$passwordHashed',DEFAULT)";
        $resultset=executeQuery($mysqlcon,$createUser);

        echo "Created user $id with mail $email\n";
    }

    $mysqlcon->close();
}
catch (Exception $exception)
{
    echo $exception->getMessage();
}
?>
</body>

