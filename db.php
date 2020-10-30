<?php


        $host = '172.18.0.3';
        $user = 'publican_web';
        $pass = 'mUhcLLH2wILAUhIbsIfS';
        $name = 'doug_database';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$name;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        /* 
        $mysqli = new mysqli($host, $user, $pass, $name);
        */
        try {
            $DBH = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }




    function db_close() {
        /*
        $this->db->close();
        */
        $DBH= null;
        
        return true;
    }

?>