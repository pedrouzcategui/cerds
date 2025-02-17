<?php

require_once "../db.php";

class Instructor
{
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone;
    private static $table = "instructors";

    // Constructor
    function __construct($id, $first_name, $last_name, $email, $phone)
    {
        $this->setId($id);
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setEmail($email);
        $this->setPhone($phone);
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $instructors = [];
        foreach ($result as $instructor) {
            $instructors[] = new self(
                $instructor['id'],
                $instructor['first_name'],
                $instructor['last_name'],
                $instructor['email'],
                $instructor['phone']
            );
        }
        return $instructors;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $instructor = $result[0];
            return new self(
                $instructor['id'],
                $instructor['first_name'],
                $instructor['last_name'],
                $instructor['email'],
                $instructor['phone']
            );
        }
        return null;
    }

    public static function create($first_name, $last_name, $email, $phone)
    {
        $instructorId = DB::query("INSERT INTO " . self::$table . " (first_name, last_name, email, phone) VALUES (?, ?,?, ?)", [$first_name, $last_name, $email, $phone]);
        return new self(
            $instructorId,
            $first_name,
            $last_name,
            $email,
            $phone
        );
    }
    public static function update($id, $first_name, $last_name, $email, $phone)
    {
        DB::query("UPDATE " . self::$table . " SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?", [$first_name, $last_name, $email, $phone, $id]);
        return new self(
            $id,
            $first_name,
            $last_name,
            $email,
            $phone
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
}
