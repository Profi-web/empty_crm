<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/libraries/Medoo.php';
if ($_SERVER['HTTP_HOST'] === 'hostdb') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'databasedb',
        'server' => 'localhost',
        'username' => 'databaseusername',
        'password' => 'passworddatabase'
    );
} elseif ($_SERVER['HTTP_HOST'] === 'hostdb') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'databasedb',
        'server' => 'localhost',
        'username' => 'databaseusername',
        'password' => 'passworddatabase'
    );
} else {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'databasedb',
        'server' => 'localhost',
        'username' => 'databaseusername',
        'password' => 'passworddatabase'
    );
}
$host 		= 'localhost';
$database 	= 'databasedb';
$db_user 	= 'databaseusername';
$db_passw 	= 'passworddatabase';

error_reporting( 0 );

$con = mysqli_connect( $host, $db_user, $db_passw, $database );
mysqli_select_db( $con, $database );

if( mysqli_connect_errno() ) {
    die( 'Verbinding met MySQL is mislukt: ' . mysqli_connect_error() );
}
function dbQuery( $query ) {
    global $con;
    $sql = mysqli_query( $con, $query );
    return $sql;
}
define("DB_INIT", $db);
