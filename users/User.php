<?php

require_once "c:/xampp/htdocs/sistema-cursos/db.php";

class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $phone;
    private $created_at;
    private $updated_at;
    private static $table = "users";

    // Constructor
    function __construct($id, $username, $email, $password, $phone, $created_at, $updated_at)
    {
        $this->setId($id);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPhone($phone);
        $this->setCreatedAt($created_at);
        $this->setUpdatedAt($updated_at);
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    // Methods
    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $users = [];
        foreach ($result as $user) {
            $users[] = new self(
                $user['id'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['phone'],
                $user['created_at'],
                $user['updated_at']
            );
        }
        return $users;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $user = $result[0];
            return new self(
                $user['id'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['phone'],
                $user['created_at'],
                $user['updated_at']
            );
        }
        return null;
    }

    public static function create($username, $email, $password, $phone)
    {
        $hashedPassword = md5($password);
        $userId = DB::query("INSERT INTO " . self::$table . " (username, email, password, phone) VALUES (?, ?, ?, ?)", [$username, $email, $hashedPassword, $phone]);
        return new self(
            $userId,
            $username,
            $email,
            $hashedPassword,
            $phone,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
    }

    public static function update($id, $username, $email, $password, $phone)
    {
        $hashedPassword = md5($password);
        DB::query("UPDATE " . self::$table . " SET username = ?, email = ?, password = ?, phone = ?, updated_at = NOW() WHERE id = ?", [$username, $email, $hashedPassword, $phone, $id]);
        return new self(
            $id,
            $username,
            $email,
            $hashedPassword,
            $phone,
            null,
            date('Y-m-d H:i:s')
        );
    }

    public static function delete($id)
    {
        try {
            DB::query("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
        } catch (\Throwable $th) {
            Utils::prettyDump($th);
        }
    }

    public static function findByUsername($username)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE username = ?", [$username]);
        if (count($result) > 0) {
            $user = $result[0];
            return new self(
                $user['id'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['phone'],
                $user['created_at'],
                $user['updated_at']
            );
        }
        return null;
    }
}
