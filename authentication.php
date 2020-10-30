<?php
// Connect to Database.

require('db.php');

echo "DB connection Completed.<br>";
// Check if data from form was submitted.


if (!isset($_POST['username'], $_POST['password'])) {
    die ('Please fill both Username and Password fields.');
    echo "Data check for POST variables Completed.<br>";
}

// Check if Username is valid

if ($stmt = $DBH->prepare('SELECT id, username, password FROM users WHERE username = ?')) {
    $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll();
    
    echo "PDO Statement Completed<br>";
    
    
    if ($stmt->rowCount() > 0) {
        //$stmt->bindparam(1, $username, PDO::PARAM_STR);
        //$stmt->bindparam(2, $password, PDO::PARAM_STR);
        $userId = $results['0']['id'];
        $username = $results['0']['username'];
        $password = $results['0']['password'];

        echo "userID is: " . $userId . "<br>";
        echo "username is: " . $username . "<br>";
        
            
        // If username is present verify password and generate session ID and set cookie;
        
        if (password_verify($_POST['password'], $password)) {
    
            $stmt = $DBH->prepare('SELECT session_id FROM sessions WHERE user_id =?');
            $stmt->bindparam(1, $userId, PDO::PARAM_STR); 
            $stmt->execute();

            if($stmt->rowcount() > 0) {
                
                $name = "publican_cookie";
                $sessionIdBin = openssl_random_pseudo_bytes(128, $crypto_strong );
                $sessionIdHex = bin2hex($sessionIdBin);
                $time = time();
            
                $stmt = $DBH->prepare('UPDATE sessions SET session_id=?, set_time=? WHERE user_id=?');
                $stmt->bindparam(1, $sessionIdHex, PDO::PARAM_STR); 
                $stmt->bindparam(2, $time, PDO::PARAM_STR);
                $stmt->bindparam(3, $userId, PDO::PARAM_STR); 
                $stmt->execute();

                setcookie($name, $sessionIdHex);
                //echo 'Old Session Updated, Welcome ' . $username . '!';
                header('Location: home.php');
            
            
            } else {
            
                    $name = "publican_cookie";
                    $sessionIdBin = openssl_random_pseudo_bytes(128, $crypto_strong );
                    $sessionIdHex = bin2hex($sessionIdBin);
                    $time = time();
            
                    $stmt = $DBH->prepare('INSERT INTO sessions (session_id, user_id, set_time) VALUES (?, ?, ?)');
                    $stmt->bindparam(1, $sessionIdHex, PDO::PARAM_STR); 
                    $stmt->bindparam(2, $userId, PDO::PARAM_STR); 
                    $stmt->bindparam(3, $time, PDO::PARAM_STR);
                    $stmt->execute();

                    setcookie($name, $sessionIdHex);
                    //echo 'Welcome ' . $username . '!';
                    header('Location: home.php');
                }

        } else {
            echo "Incorrect Password";
        }
    } else {
        echo "Incorrect Username<br>";
        }
} else {
    echo "something else went wrong<br>";
}

?>