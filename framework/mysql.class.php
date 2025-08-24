<?php

class DB {
    private $connection; // mysqli connection
    private $result;     // result set

    public function __construct() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if (!$this->connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->connection, 'utf8');
    }

    public function disconnect() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
	public function getConnexion() {
        return $this->connection;
    }
    public function isConnected() {
        return $this->connection ? true : false;
    }

    public function setQuery($query) {
        $this->result = mysqli_query($this->connection, $query);

        if (!$this->result) {
            echo "MySQL Error: " . mysqli_error($this->connection) . "<br>Query: " . htmlspecialchars($query);
            return false;
        }
        return true;
    }

    public function query($query) {
        $this->result = mysqli_query($this->connection, $query);

        if (!$this->result) {
            echo "MySQL Error: " . mysqli_error($this->connection) . "<br>Query: " . htmlspecialchars($query);
        }

        return $this->result;
    }

    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }

    public function loadResult($query = '') {
        if ($query) {
            if (!$this->setQuery($query)) return null;
        }
        if ($this->result && $data = mysqli_fetch_array($this->result, MYSQLI_NUM)) {
            return $data[0];
        }
        return null;
    }

    public function loadResultArray($query = '') {
        if ($query) {
            if (!$this->setQuery($query)) return [];
        }
        if ($this->result && $data = mysqli_fetch_array($this->result, MYSQLI_ASSOC)) {
            return $data;
        }
        return [];
    }

    public function loadObject($query = '') {
        if ($query) {
            if (!$this->setQuery($query)) return null;
        }
        if ($this->result && $data = mysqli_fetch_object($this->result)) {
            return $data;
        }
        return null;
    }

    public function loadArrayList($query = '') {
        if ($query) {
            if (!$this->setQuery($query)) return [];
        }
        $datas = [];
        if ($this->result) {
            while ($data = mysqli_fetch_array($this->result, MYSQLI_ASSOC)) {
                $datas[] = $data;
            }
        }
        return $datas;
    }

    public function loadObjectList($query = '') {
        if ($query) {
            if (!$this->setQuery($query)) return [];
        }
        $datas = [];
        if ($this->result) {
            while ($data = mysqli_fetch_object($this->result)) {
                $datas[] = $data;
            }
        }
        return $datas;
    }

    public function escape($string) {
        return mysqli_real_escape_string($this->connection, $string);
    }
}
