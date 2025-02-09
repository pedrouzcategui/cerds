<?php

require_once "../db.php";
require_once "../courses/Course.php";

class PTO
{
    private $id;
    private $instructor_id;
    private $course_id;
    private $start_date;
    private $end_date;
    private $status;
    private $reason; // New attribute
    private static $table = "pto_requests";

    // Constructor
    function __construct($id, $instructor_id, $course_id, $start_date, $end_date, $status, $reason)
    {
        $this->setId($id);
        $this->setInstructorId($instructor_id);
        $this->setCourseId($course_id);
        $this->setStartDate($start_date);
        $this->setEndDate($end_date);
        $this->setStatus($status);
        $this->setReason($reason); // Set the new attribute
    }

    // Getters and setters...
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getInstructorId()
    {
        return $this->instructor_id;
    }

    public function setInstructorId($instructor_id)
    {
        $this->instructor_id = $instructor_id;
    }

    public function getCourseId()
    {
        return $this->course_id;
    }

    public function setCourseId($course_id)
    {
        $this->course_id = $course_id;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $ptos = [];
        foreach ($result as $pto) {
            $ptos[] = new self(
                $pto['id'],
                $pto['instructor_id'],
                $pto['course_id'],
                $pto['start_date'],
                $pto['end_date'],
                $pto['status'],
                $pto['reason'] // Include the new attribute
            );
        }
        return $ptos;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $pto = $result[0];
            return new self(
                $pto['id'],
                $pto['instructor_id'],
                $pto['course_id'],
                $pto['start_date'],
                $pto['end_date'],
                $pto['status'],
                $pto['reason'] // Include the new attribute
            );
        }
        return null;
    }

    public static function create($instructor_id, $course_id, $start_date, $end_date, $status, $reason)
    {
        $ptoId = DB::query("INSERT INTO " . self::$table . " (instructor_id, course_id, start_date, end_date, status, reason) VALUES (?, ?, ?, ?, ?, ?)", [$instructor_id, $course_id, $start_date, $end_date, $status, $reason]);
        return new self(
            $ptoId,
            $instructor_id,
            $course_id,
            $start_date,
            $end_date,
            $status,
            $reason // Include the new attribute
        );
    }

    public static function update($id, $instructor_id, $course_id, $start_date, $end_date, $status, $reason)
    {
        DB::query("UPDATE " . self::$table . " SET instructor_id = ?, course_id = ?, start_date = ?, end_date = ?, status = ?, reason = ? WHERE id = ?", [$instructor_id, $course_id, $start_date, $end_date, $status, $reason, $id]);
        return new self(
            $id,
            $instructor_id,
            $course_id,
            $start_date,
            $end_date,
            $status,
            $reason // Include the new attribute
        );
    }

    public static function delete($id)
    {
        DB::query("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
    }

    public static function adjustCourseEndDate($course_id, $pto_start_date, $pto_end_date)
    {
        $course = Course::findById($course_id);
        if ($course) {
            $course_end_date = new DateTime($course->getEndDate());
            $pto_start = new DateTime($pto_start_date);
            $pto_end = new DateTime($pto_end_date);

            if ($pto_start <= $course_end_date) {
                $interval = $pto_end->diff($pto_start)->days + 1;
                $course_end_date->modify("+$interval days");
                Course::updateEndDate($course_id, $course_end_date->format('Y-m-d'));
            }
        }
    }
}
