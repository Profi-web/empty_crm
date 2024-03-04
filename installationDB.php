<?php
// Retrieve form data
$host = $_POST['host'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$database = $_POST['database'] ?? null;
$tinymce = $_POST['tinymce'] ?? null;

// Check if required fields are filled
if (!$tinymce || !$password || !$username || !$database) {
    die("Vul alles in homo");
}

$filename = './includes/config.php';
$filename1 = './components/footer.php';
$file = fopen($filename, 'r+');
$file1 = fopen($filename1, 'r+');
if($file && $file1){
    flock($file, LOCK_EX);
    $fileContent = fread($file, filesize($filename));

    $databasehost = str_replace('hostdb', $host, $fileContent);
    $databaseusername = str_replace('databaseusername', $username, $fileContent);
    $databasepassword = str_replace('passworddatabase',$password , $fileContent);
    $databasename = str_replace('databasedb', $database, $fileContent);
    rewind($file);
    fwrite($file, $databasehost);
    fwrite($file, $databaseusername);
    fwrite($file, $databasepassword);
    fwrite($file, $databasename);
    flock($file, LOCK_UN);
    fclose($file);

    flock($file1, LOCK_EX);
    $fileContent1 = fread($file, filesize($filename));

    $tinymcekey = str_replace('tinymceapikey', $tinymce, $fileContent1);

    rewind($file1);
    fwrite($file1, $tinymcekey);
    flock($file1, LOCK_UN);
    fclose($file1);

    header($host);
}
else{
    echo 'failed to open file.';
}
// Write to config.php file
//if ($file) {
//    fwrite($file, $newcontent);
//    fclose($file);
//    echo "Database configuration saved successfully.";
//} else {
//    echo "Error writing to config.php file.";
//}

// Redirect to login page
//header("Location: .$host.");
exit;