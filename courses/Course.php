<?php

require_once __DIR__ . "/../db.php";
require_once "../instructors/Instructor.php";
require_once "../labs/Lab.php";

class Course
{
    private $id;
    private $instructor_id;
    private $lab_id;
    private $name;
    private $description;
    private $start_date;
    private $end_date;
    private $status = 'PENDING';
    private static $table = "courses";

    // Constructor
    function __construct($id, $instructor_id, $lab_id, $name, $description, $start_date, $end_date, $status = 'PENDING')
    {
        $this->setId($id);
        $this->setInstructorId($instructor_id);
        $this->setLabId($lab_id);
        $this->setName($name);
        $this->setDescription($description);
        $this->setStartDate($start_date);
        $this->setEndDate($end_date);
        $this->setStatus($status);
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getInstructorId()
    {
        return $this->instructor_id;
    }

    public function getLabId()
    {
        return $this->lab_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function instructor()
    {
        return Instructor::findById($this->instructor_id);
    }

    public function lab()
    {
        return Lab::findById($this->lab_id);
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setInstructorId($instructor_id)
    {
        $this->instructor_id = $instructor_id;
    }

    public function setLabId($lab_id)
    {
        $this->lab_id = $lab_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $courses = [];
        foreach ($result as $course) {
            $courses[] = new self(
                $course['id'],
                $course['instructor_id'],
                $course['lab_id'],
                $course['name'],
                $course['description'],
                $course['start_date'],
                $course['end_date'],
                $course['status']
            );
        }
        return $courses;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $course = $result[0];
            return new self(
                $course['id'],
                $course['instructor_id'],
                $course['lab_id'],
                $course['name'],
                $course['description'],
                $course['start_date'],
                $course['end_date'],
                $course['status']
            );
        }
        return null;
    }

    public static function create($instructor_id, $lab_id, $name, $description, $start_date, $end_date, $status = 'PENDING')
    {
        $courseId = DB::query("INSERT INTO " . self::$table . " (instructor_id, lab_id, name, description, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)", [$instructor_id, $lab_id, $name, $description, $start_date, $end_date, $status]);
        return new self(
            $courseId,
            $instructor_id,
            $lab_id,
            $name,
            $description,
            $start_date,
            $end_date,
            $status
        );
    }

    public static function update($id, $instructor_id, $lab_id, $name, $description, $start_date, $end_date, $status)
    {
        try {
            DB::query("UPDATE " . self::$table . " SET instructor_id = ?, lab_id = ?, name = ?, description = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?", [$instructor_id, $lab_id, $name, $description, $start_date, $end_date, $status, $id]);
            return new self(
                $id,
                $instructor_id,
                $lab_id,
                $name,
                $description,
                $start_date,
                $end_date,
                $status
            );
        } catch (\Throwable $th) {
            Utils::prettyDump($th);
        }
    }

    public static function delete($id)
    {
        try {
            DB::query("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
        } catch (\Throwable $th) {
            Utils::prettyDump($th);
        }
    }

    public function getCurrentEnrollments()
    {
        $result = DB::query("SELECT COUNT(*) as count FROM payments WHERE course_id = ?", [$this->id]);
        return $result[0]['count'];
    }

    public static function updateEndDate($id, $end_date)
    {
        DB::query("UPDATE " . self::$table . " SET end_date = ?, updated_at = NOW() WHERE id = ?", [$end_date, $id]);
    }
}
