<!DOCTYPE html>
<html>
<head>
    <title>Database Setup Form</title>
</head>
<body>
<h2>Database Setup</h2>
<form action="installationDB.php" method="post">
    <label for="host">Database Host:</label>
    <input type="text" id="host" name="host" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <label for="database">Database Name:</label>
    <input type="text" id="database" name="database" required><br><br>
    <label for="tinymce">TinyMCE API key</label>
    <input type="text" id="tinymce" name="tinymce"><br/><br/>

    <input type="submit" value="Submit">
</form>
</body>
</html>