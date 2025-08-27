<?php
class DB
{
    private $serverName, $user, $pass, $db, $port;

    function __construct()
    {
        // ถ้าใช้ Docker stack เดิม: host คือชื่อ service "db"
        // นอก Docker/Local ปกติ: "127.0.0.1"
        $this->serverName = getenv('DB_HOST') ?: 'db';
        $this->user = getenv('DB_USER') ?: 'appuser';
        $this->pass = getenv('DB_PASS') ?: 'changeme_app';
        $this->db = getenv('DB_NAME') ?: 'appdb';
        $this->port = intval(getenv('DB_PORT') ?: 3306);
    }

    public function setDBname($dbname)
    {
        $this->db = $dbname;
    }

    public function setHost($dbname, $ip, $user, $pass, $port = 3306)
    {
        $this->serverName = $ip;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $dbname;
        $this->port = $port;
    }

    private function connect()
    {
        $mysqli = @new mysqli($this->serverName, $this->user, $this->pass, $this->db, $this->port);
        if ($mysqli->connect_errno) {
            echo "Connection could not be established.<br />";
            die($mysqli->connect_error);
        }
        // บังคับ charset เป็น utf8mb4
        if (!$mysqli->set_charset("utf8mb4")) {
            echo "Error loading character set utf8mb4<br />";
            die($mysqli->error);
        }
        return $mysqli;
    }

    public function Query($query)
    {
        $conn = $this->connect();
        $res = $conn->query($query);
        if ($res === false) {
            echo $conn->error;
            $conn->close();
            die();
        }
        $array = [];
        while ($row = $res->fetch_assoc()) {
            $array[] = $row;
        }
        $res->free();
        $conn->close();
        return $array;
    }

    public function Query1($query)
    {
        $conn = $this->connect();
        if (method_exists($conn, 'set_charset')) {
            $conn->set_charset("utf8mb4");
        }

        $res = $conn->query($query);
        if ($res === false) {
            $err = $conn->error;
            $conn->close();
            throw new Exception($err);
        }

        // ถ้าเป็น SELECT ดึงข้อมูลออกมา
        if ($res instanceof mysqli_result) {
            $rows = [];
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
            $res->free();
            $conn->close();
            return $rows;  // <<<<<< คืน rows
        }

        // ถ้าเป็น INSERT/UPDATE/DELETE คืนผลลัพธ์ boolean/affected rows
        $affected = $conn->affected_rows;
        $conn->close();
        return $affected; // หรือ return true;
    }

    public function insert($tb_name, $cols, $values, $type)
    {
        // NOTE: เหมือนของเดิม (string concat) — ควรระวัง SQL Injection
        $query = "INSERT INTO `$tb_name`(" . implode(",", array_map(fn($c) => "`$c`", $cols)) . ") VALUES(";
        $parts = [];
        for ($i = 0; $i < count($values); $i++) {
            $t = $type[$i];
            if ($t === 's' || $t === 'sn') {
                $parts[] = "'" . $this->escape($values[$i]) . "'";
            } else {
                // ตัวเลข/บูลีน
                $parts[] = $values[$i];
            }
        }
        $query .= implode(",", $parts) . ")";
        return $this->Query1($query);
    }

    public function insert_return($tb_name, $cols, $values, $type, $pk)
    {
        // MySQL ใช้ LAST_INSERT_ID() แทน OUTPUT inserted.pk
        $this->insert($tb_name, $cols, $values, $type);
        $row = $this->Query("SELECT LAST_INSERT_ID() AS `$pk`");
        return $row; // ให้ผลลัพธ์รูปแบบเดียวกับเดิม: array[0]['pk']
    }

    public function update($tb_name, $cols, $values, $type, $Ccols, $Cvalues, $Ctype)
    {
        $sets = [];
        for ($i = 0; $i < count($cols); $i++) {
            $col = "`{$cols[$i]}`";
            $t = $type[$i];
            if ($t === 's' || $t === 'sn') {
                $sets[] = "$col = '" . $this->escape($values[$i]) . "'";
            } else {
                $sets[] = "$col = " . $values[$i];
            }
        }

        $query = "UPDATE `$tb_name` SET " . implode(",", $sets);

        if ($Ccols != null && count($Ccols) > 0) {
            $wheres = [];
            for ($i = 0; $i < count($Ccols); $i++) {
                $c = "`{$Ccols[$i]}`";
                $t = $Ctype[$i];
                if ($t === 's' || $t === 'sn') {
                    $wheres[] = "$c = '" . $this->escape($Cvalues[$i]) . "'";
                } else {
                    $wheres[] = "$c = " . $Cvalues[$i];
                }
            }
            $query .= " WHERE " . implode(" AND ", $wheres);
        }

        return $this->Query1($query);
    }

    private function escape($val)
    {
        // ใช้การเชื่อมต่อชั่วคราวเพื่อ real_escape_string (ไม่ดีเท่าพรีแพร์ แต่คงรูปแบบเดิม)
        $conn = $this->connect();
        $escaped = $conn->real_escape_string($val);
        $conn->close();
        return $escaped;
    }
}
