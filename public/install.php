<?php

use SleekDB\Store;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$store = new Store("users", dirname(__DIR__) . '/data/sleekdb');

$username = 'admin';
$password = 'admin';

if (count($store->findAll()) > 0) {
    header('Location: /');
    exit;
}

$store->insert([
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
]);

$message = "Installation successful!";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $message; ?></h1>
        <p>Username: <?php echo $username; ?></p>
        <p>Password: <?php echo $password; ?></p>
        <a href="/" class="button">Continue to Login</a>
    </div>
</body>
</html>
