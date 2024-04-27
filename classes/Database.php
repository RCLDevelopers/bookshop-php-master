<?php
class Database {

    private $db_host = DB_HOST;
    private $db_name = DB_NAME;
    private $db_user = DB_USER;
    private $db_password = DB_PASSW;
    private $mysqli;

    private static $instance = null;
 
    public $error;
    public $insertID;
    public $isConnected = false;
    public $count;

    public function __construct() {
        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name); //połączenie z bazą danych
        $this->mysqli->set_charset("utf8");
        if (!$this->mysqli->connect_errno) //sprawdza czy połączyło z bazą
           $this->isConnected = true;
        else {
            $this->isConnected = false;
            $this->error = $this->mysqli->connect_error;
        }
    }

    public static function getInstance() {
        if(!isset(self::$instance)) { //jeżeli instancja nie istnieje to tworzy nową
            self::$instance = new Database();
        }
        return self::$instance; //zwraca instancje klasy Database
    }

    private function select_query($sql) {
        if ($this->isConnected) { //sprawdzenie czy istanieje połączenie z bazą
            if (isset($sql) && $sql != '') { //sprawdzenie czy wprowadzono jakieś zapytanie
                if ($result = $this->mysqli->query($sql)) { //wykonanie zapytania
                    $this->count = $result->num_rows; //ilość zwróconych rekordów
                    return $result;
                } else
                    $this->error = mysql_error();
            }
            else
                $this->error = 'Brak zapytania SQL';
        }
        else 
            $this->error = 'Błąd połączenia z bazą danych';
    }

    public function select($sql, $class = false) {
        if($result = $this->select_query($sql)) {
            $return = array();
            if($class) //mapowanie danych na daną klasę
                while ($row = $result->fetch_object($class))
                    $return[] = $row;
            else
                while ($row = $result->fetch_object())
                    $return[] = $row;
            return $return;
        }
    }


    public function insert($sql) {
         if ($this->isConnected) { 
            if (isset($sql) && $sql != '') { 
                if ($this->mysqli->query($sql)) { 
                    $this->insertID = $this->mysqli->insert_id;
                    return true;
                } else
                    $this->error = mysql_error();
            }
            else
                $this->error = 'Brak zapytania SQL';
        }
        else 
            $this->error = 'Błąd połączenia z bazą danych';

        return false;
    }

    public function update($sql) {
        return  $this->query($sql);
    }

    public function delete($sql) {
        return  $this->query($sql);
    }

    private function query($sql) {
         if ($this->isConnected) { 
            if (isset($sql) && $sql != '') { 
                if ($this->mysqli->query($sql) === true) { 
                    return true;
                } else
                    $this->error = mysql_error();
            }
            else
                $this->error = 'Brak zapytania SQL';
        }
        else 
            $this->error = 'Błąd połączenia z bazą danych';

        return false;
    }

    public function close() {
        if ($this->isConnected)
            $this->mysqli->close(); //zamknięcie połączenia z bazą
        else
            $this->error = 'Błąd połączenia z bazą danych';
    }

}