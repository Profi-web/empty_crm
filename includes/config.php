<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/libraries/Medoo.php';
if ($_SERVER['HTTP_HOST'] === 'dbemtpy.basiccrm.nl') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'basiccrm_main',
        'server' => 'localhost',
        'username' => 'basiccrm_main',
        'password' => 'hwVCjtHVJKcd53D7qZn6'
    );
} elseif ($_SERVER['HTTP_HOST'] === 'dbemtpy.basiccrm.nl ') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'basiccrm_main',
        'server' => 'localhost',
        'username' => 'basiccrm_main',
        'password' => 'hwVCjtHVJKcd53D7qZn6'
    );
} else {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'basiccrm_main',
        'server' => 'localhost',
        'username' => 'basiccrm_main',
        'password' => 'hwVCjtHVJKcd53D7qZn6'
    );
}
$host 		= 'localhost';
$database 	= 'basiccrm_main';
$db_user 	= 'basiccrm_main';
$db_passw 	= 'hwVCjtHVJKcd53D7qZn6';

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
