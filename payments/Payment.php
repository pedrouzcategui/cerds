<?php

require_once "../db.php";
require_once "../instructors/Instructor.php";
require_once "../students/Student.php";
require_once "../labs/Lab.php";
require_once "../courses/Course.php";

class Payment
{
    private $id;
    private $student_id;
    private $course_id;
    private $amount;
    private $currency;
    private $reference;
    private $image;
    private $date;
    private $status;
    private $student;
    private $course;
    private static $table = "payments";

    // Constructor
    function __construct($id, $student_id, $course_id, $amount, $currency, $reference, $image, $date, $status)
    {
        $this->setId($id);
        $this->setStudentId($student_id);
        $this->setCourseId($course_id);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $this->setReference($reference);
        $this->setImage($image);
        $this->setDate($date);
        $this->setStatus($status);
        $this->setStudent();
        $this->setCourse();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getStudentId()
    {
        return $this->student_id;
    }

    public function getCourseId()
    {
        return $this->course_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function getStudent()
    {
        return $this->student;
    }
    public function getCourse()
    {
        return $this->course;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStudentId($student_id)
    {
        $this->student_id = $student_id;
    }

    public function setCourseId($course_id)
    {
        $this->course_id = $course_id;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setStudent()
    {
        $this->student = Student::findById($this->student_id);
    }
    public function setCourse()
    {
        $this->course = Course::findById($this->course_id);
    }

    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $payments = [];
        foreach ($result as $payment) {
            $payments[] = new self(
                $payment['id'],
                $payment['student_id'],
                $payment['course_id'],
                $payment['amount'],
                $payment['currency'],
                $payment['reference'],
                $payment['image'],
                $payment['date'],
                $payment['status']
            );
        }
        return $payments;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $payment = $result[0];
            return new self(
                $payment['id'],
                $payment['student_id'],
                $payment['course_id'],
                $payment['amount'],
                $payment['currency'],
                $payment['reference'],
                $payment['image'],
                $payment['date'],
                $payment['status']
            );
        }
        return null;
    }

    public static function create($student_id, $course_id, $amount, $currency, $reference, $image, $date, $status)
    {
        $paymentId = DB::query("INSERT INTO " . self::$table . " (student_id, course_id, amount, currency, reference, image, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$student_id, $course_id, $amount, $currency, $reference, $image, $date, $status]);
        return new self(
            $paymentId,
            $student_id,
            $course_id,
            $amount,
            $currency,
            $reference,
            $image,
            $date,
            $status
        );
    }

    public static function update($id, $student_id, $course_id, $amount, $currency, $reference, $image, $date, $status)
    {
        try {
            DB::query("UPDATE " . self::$table . " SET student_id = ?, course_id = ?, amount = ?, currency = ?, reference = ?, image = ?, date = ?, status = ? WHERE id = ?", [$student_id, $course_id, $amount, $currency, $reference, $image, $date, $status, $id]);
            return new self(
                $id,
                $student_id,
                $course_id,
                $amount,
                $currency,
                $reference,
                $image,
                $date,
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

    public static function getTotalPayments($currency)
    {
        if (!in_array($currency, ['VES', 'USD'])) {
            throw new InvalidArgumentException("Invalid currency. Only 'VES' and 'USD' are allowed.");
        }

        $total = 0;
        $payments = self::getAll();
        foreach ($payments as $payment) {
            if ($payment->getCurrency() == $currency) {
                $total += $payment->getAmount();
            }
        }
        return $total;
    }

    public static function getTotalPaymentsByCourse($course_id, $currency)
    {
        if (!in_array($currency, ['VES', 'USD'])) {
            throw new InvalidArgumentException("Invalid currency. Only 'VES' and 'USD' are allowed.");
        }

        $total = 0;
        $payments = DB::query("SELECT * FROM " . self::$table . " WHERE course_id = ?", [$course_id]);
        foreach ($payments as $payment) {
            if ($payment['currency'] == $currency) {
                $total += $payment['amount'];
            }
        }
        return $total;
    }
}
