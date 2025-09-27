<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DB
{
    private $connection;
    private $result;

    public function __construct() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if (!$this->connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->connection, 'utf8');
    }
    
public function query(string $sql)
{
    $this->result = mysqli_query($this->connection, $sql);
    if ($this->result === false) {
        throw new Exception("MySQL Query Error: " . mysqli_error($this->connection));
    }
    return $this->result;
}
public function affected_rows(): int
{
    return mysqli_affected_rows($this->connection);
}
public function escape(string $value): string
{
    return mysqli_real_escape_string($this->connection, $value);
}

    public static function getVar(string $name, mixed $default = null, string $scope = 'request'): mixed
    {
        switch (strtolower($scope)) {
            case 'get':
                return $_GET[$name] ?? $default;
            case 'post':
                return $_POST[$name] ?? $default;
            case 'session':
                return $_SESSION[$name] ?? $default;
            default: // request
                return $_REQUEST[$name] ?? $default;
        }
    }
    public function getConnexion() {
        return $this->connection;
    }
    public function loadResult($sql) {
        $res = mysqli_query($this->connection, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_row($res);
            return $row[0] ?? null;
        }
        return null;
    }
    public function loadObjectList($query) {
        $result = mysqli_query($this->connection, $query);
        $rows = [];
        while ($row = mysqli_fetch_object($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function disconnect() {
        if ($this->connection) {
            mysqli_close($this->connection);
            $this->connection = null;
        }
    }
    
    public function loadObject($query) {
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_object($result);
    }
    
    
    public static function setVar(string $name, mixed $value): void
    {
        $_SESSION[$name] = $value;
    }

    public static function unsetVar(string $name): void
    {
        unset($_SESSION[$name]);
    }

    public static function makeSelectList(
        array $arr,
        string $tag_name,
        string $tag_attribs,
        string $key,
        string $text,
        mixed $selected = null
    ): string {
        $html = "<select name=\"{$tag_name}\" {$tag_attribs}>";
        foreach ($arr as $row) {
            $k = $row[$key];
            $t = $row[$text];
            $isSel = ((string)$k === (string)$selected) ? 'selected="selected"' : '';
            $html .= "<option value=\"" . htmlspecialchars((string)$k, ENT_QUOTES) . "\" {$isSel}>"
                   . htmlspecialchars((string)$t, ENT_QUOTES)
                   . "</option>";
        }
        $html .= "</select>";
        return $html;
    }

    public static function makeOption(string $value, string $text): array
    {
        return ['value' => $value, 'text' => $text];
    }

    public static function loadMod(string $mod): void
    {
        $modFile = SITE_PATH . '/modules/' . $mod . '/' . $mod . '.php';
        if (file_exists($modFile)) {
            include $modFile;
        }
    }

    public static function loadApp(string $app): void
    {
        $appFile = SITE_PATH . '/apps/' . $app . '/' . $app . '.php';
        if (file_exists($appFile)) {
            include $appFile;
        }
    }

    public static function checkApp(string $app): bool
    {
        return file_exists(SITE_PATH . '/apps/' . $app . '/' . $app . '.php');
    }

    public static function makeSafe(string $string): string
    {
        return htmlspecialchars(strip_tags($string), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function sendMail(string $from, string $fromName, string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->isHTML(true);

            return $mail->send();
        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
