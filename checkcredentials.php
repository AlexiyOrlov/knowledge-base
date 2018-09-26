<!DOCTYPE html>
<html>
<head>
    <title>Logging in</title>
    <link rel="stylesheet" href="static/styles.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
include_once 'functions.php';
include_once 'navigation.php';
$id=$_POST[IDENTIFIER];
$password=$_POST[PASSSWORD];
$ohMy=defaultMysqlConnection();
$q="SELECT identifier, email,`group`, password,activated FROM knowledge_base.user_data WHERE identifier='$id'";

$r=executeQuery($ohMy,$q);
if($r)
{
    if(!$r[0][4])
    {
        echo "Your account was deactivated.";
    }
    else
    {
        //the password is fourth value
        $matches=password_verify($password,$r[0][3]);
        if(!$matches)
        {
            echo "Wrong password\n";
        }
        else
        {

            if(session_start())
            {
                //var_dump($_SESSION);

                try{
                    $_SESSION[IDENTIFIER]=$r[0][0];
                    $_SESSION[EMAIL]=$r[0][1];
                    $_SESSION[GROUP]=$r[0][2];
                    echo "Login successful\n";
                }
                catch (Throwable $exception)
                {
                    echo $exception->getMessage();
                }

            }

        }
    }
}
else{
    echo "Wrong username\n";
}
$ohMy->close();
?>
</body>
