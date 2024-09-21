<?php //Connection Parameter
$server = 'www.htl-projekt.com';
$database = 'kinemamilleniumsql1';
$user = 'kinemamilleniumsql1';
$pwd = '23cX%iG?';
$charset = 'utf8';

try { //Creates the connection to the Database
    $con = new PDO("mysql:host=$server;dbname=$database;charset=$charset", $user, $pwd);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) { //Error Handling
    echo "<p>Es konnte keine Verbindung zur Datenbank hergestellt werden: " . $e->getMessage() . "</p>";
}
?>