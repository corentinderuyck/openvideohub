<?php
require("password.php");

$upload_max_filesize = ini_get('upload_max_filesize');
$file_uploads = ini_get('file_uploads');
$post_max_size = ini_get('post_max_size');
$max_execution_time = ini_get('max_execution_time');
$display_errors = ini_get('display_errors');
$timezone = ini_get('date.timezone');
try
{
    $bdd = new PDO('mysql:host=localhost;dbname='.$bdd_name.';charset=utf8', $user, $password);
    $error_co = False;
    try
    {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS videos 
        (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name text,
            description text,
            likeButton INT,
            dontTlikeButton INT,
            views INT,
            autor_name text,
            autor_id INT
        )";
        $recipesStatement = $bdd->prepare($sqlQuery);
        $recipesStatement->execute();

        $sqlQuery = "CREATE TABLE IF NOT EXISTS users
        (
            id INT PRIMARY KEY AUTO_INCREMENT,
            email text,
            password text,
            name text
        )";
        $recipesStatement = $bdd->prepare($sqlQuery);
        $recipesStatement->execute();

        $error_table = False;
    }
    catch (Exception $e)
    {
        $error_table = True;
    }
}
catch (Exception $e)
{
    $error_co = True;
    $error_table = True;
}
?>

<!DOCTYPE html>
    <html lang="en">
        <meta charset="UTF-8">
        <title>Setup</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                background-color: #f2f2f2;
                color: #333;
                margin: 2em;
                padding: 0;
            }

            p {
                margin-top: 0;
                margin-bottom: 10px;
            }

            strong {
                font-weight: bold;
            }

            .error {
                color: #f00;
                font-weight: bold;
            }

            .success {
                color: #0a0;
                font-weight: bold;
            }

            .message {
                font-weight: bold;
                color: red;
            }
        </style>
    <body>
        <h1>Database information</h1>
        <p><strong>Database name : </strong><?php echo $bdd_name; ?></p>
        <p><strong>Username : </strong><?php echo $user; ?></p>
        <p><strong>Password : </strong><?php echo $password; ?></p>

        <?php
        // show message if password.php file is empty
        if(empty($bdd_name) && empty($user) && empty($password)) {
            echo "<p>configure your information in the password.php file</p>";
        }
        ?>

        <h1>Database</h1>

        <p>Database connection : <?php
        if($error_co) {
            echo "&#10060;";
        } else {
            echo "&#9989;";
        }
        ?></p>

        <p>Tables : <?php
        if($error_table) {
            echo "&#10060;";
        } else {
            echo "&#9989;";
        }
        ?></p>

        <?php
        if($error_co == False && $error_table == False) {
            echo "<p class='message'>The database is well configured, delete the setup.php file</p>"; 
        }

        ?>

        <?php
        $upload_max_filesize = ini_get('upload_max_filesize');
        $file_uploads = ini_get('file_uploads');
        ?>

        <h1>Server information</h1>
        <p>Enable file upload : <?php if($file_uploads) echo "On"; else echo "Off"; ?></p>
        <p>Maximum upload file size : <?php echo $upload_max_filesize; ?></p>
        <p>Post max size : <?php echo $post_max_size; ?></p>
        <p>Max execution time : <?php echo $max_execution_time; ?></p>
        <p>Display errors : <?php echo $display_errors; ?></p>
        <p>Timezone : <?php echo $timezone; ?></p>
    </body>
</html>