<?php
class session {
    function __construct() {

    }

    function start_session($id, $options) {
        // Hash algorthim to use for session
        $session_hash = 'sha512';

        //check if hash is avaiable
        if (in_array($session_hash, hash_algos())) {
            // Set the hash function.
            ini_set ('session.hash_function', $session_hash);
        }
        // How many bits per character of the hash
        // The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
        ini_set ('session.hash_bits_per_character', 5);

        // For the session only to use cookies, not URL varaiable.
        ini_set('session.use_only_cookies', 1);
    }

    function open() {
        $host = '172.18.0.3';
        $user = 'publican_web';
        $pass = 'mUhcLLH2wILAUhIbsIfS';
        $name = 'doug_database';
        $mysqli = new mysqli($host, $user, $pass, $name);
        $this->db = $mysqli;
        return true;
    }


    function read($id) {
        if(!isset($this->read_stmt)) {
            $this->read_stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = ? LIMIT 1");    
        }
        $this->read_stmt->bind_param('s', $id);
        $this->read_stmt->execute();
        $this->read_stmt->store_result();
        $this->read_stmt->bind_result($data);
        $this->read_stmt->fetch();
        $key = $this->getkey($id);
        $data = $this->decrypt($data, $key);
        return $data;
    }
}



?>