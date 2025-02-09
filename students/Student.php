<?php

require_once "c:/xampp/htdocs/sistema-cursos/db.php";

class Student
{
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone;

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
        $result = DB::query("SELECT * FROM students ORDER BY last_name $order");
        $students = [];
        foreach ($result as $student) {
            $students[] = new self(
                $student['id'],
                $student['first_name'],
                $student['last_name'],
                $student['email'],
                $student['phone']
            );
        }
        return $students;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM students WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $student = $result[0];
            return new self(
                $student['id'],
                $student['first_name'],
                $student['last_name'],
                $student['email'],
                $student['phone']
            );
        }
        return null;
    }

    public static function create($first_name, $last_name, $email, $phone)
    {
        $studentId = DB::query("INSERT INTO students (first_name, last_name, email, phone) VALUES (?, ?,?, ?)", [$first_name, $last_name, $email, $phone]);
        return new self(
            $studentId,
            $first_name,
            $last_name,
            $email,
            $phone
        );
    }
    public static function update($id, $first_name, $last_name, $email, $phone)
    {
        DB::query("UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?", [$first_name, $last_name, $email, $phone, $id]);
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
            DB::query("DELETE FROM students WHERE id = ?", [$id]);
        } catch (\Throwable $th) {
            Utils::prettyDump($th);
        }
    }
}
