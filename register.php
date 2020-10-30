<?php

require 'db.php';
// validate form fields are not blank

// create user by creating database record

$username = 'dougcj37';
$password = 'testpass';
$email = 'dougcj37@gmail.com';
$time_stamp = time();


if($stmt = $DBH->prepare('SELECT id, password FROM users WHERE username = ?')) {
    $stmt->bindparam(1, $username, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch();

    if ($stmt->rowCount() > 0 ) {
        echo 'Username already exists';
    } else {
        $stmt = $DBH->prepare('INSERT INTO users (username, password, email, time_stamp) VALUES (?, ?, ?, ?)');
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindparam(1, $username, PDO::PARAM_STR);
        $stmt->bindparam(2, $password, PDO::PARAM_STR);
        $stmt->bindparam(3, $email, PDO::PARAM_STR);
        $stmt->bindparam(4, $time_stamp, PDO::PARAM_STR);

        $stmt->execute();
        echo 'Registration Succesful';

    }
    //$stmt->close();
} else {
    echo 'Could not complete SQL query';
}

//$DBH->close();



?>