<?php

require_once "c:/xampp/htdocs/sistema-cursos/db.php";

class Lab
{
    private $id;
    private $name;
    private $capacity;
    private $schedule;
    private $created_at;
    private $updated_at;
    private static $table = 'labs';

    // Constructor
    function __construct($id = null, $name, $capacity, $schedule, $created_at = NULL, $updated_at = NULL)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCapacity($capacity);
        $this->setSchedule($schedule);
        $this->setCreatedAt($created_at);
        $this->setUpdatedAt($updated_at);
    }
    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCapacity()
    {
        return $this->capacity;
    }
    public function getSchedule()
    {
        return $this->schedule;
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
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
    // Utils
    public static function getAll($order = 'ASC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $labs = [];
        foreach ($result as $lab) {
            $lab = new self(
                $lab['id'],
                $lab['name'],
                $lab['capacity'],
                $lab['schedule'],
                $lab['created_at'],
                $lab['updated_at']
            );
            array_push($labs, $lab);
        }
        return $labs;
    }

    public static function findById($id)
    {
        $result = DB::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        if (count($result) > 0) {
            $result = $result[0];
            $lab = new self(
                $result['id'],
                $result['name'],
                $result['capacity'],
                $result['schedule'],
                $result['created_at'],
                $result['updated_at']
            );
            return $lab;
        }
        return null;
    }

    public static function create($name, $capacity, $schedule)
    {
        $labId = DB::query("INSERT INTO " . self::$table . " (name, capacity, schedule) VALUES (?, ?, ?)", [$name, $capacity, $schedule]);
        return new self($labId, $name, $capacity, $schedule);
    }
    public static function update($id, $name, $capacity, $schedule)
    {
        try {
            $update = DB::query(
                "UPDATE " . self::$table . " SET name = ?, capacity = ?, schedule = ?, updated_at = NOW() WHERE id = ?",
                [$name, $capacity, $schedule, $id]
            );
            return $update;
        } catch (\Throwable $th) {
            Utils::prettyDump($th);
        }
    }
    public static function delete($id)
    {
        return DB::query("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
    }
    public function printPrettySchedule()
    {
        $schedule = json_decode($this->getSchedule(), true);

        if (empty($schedule)) {
            return "<p>No schedule available.</p>";
        }

        $dayNames = [
            'L' => 'Lunes',
            'M' => 'Martes',
            'X' => 'Miércoles',
            'J' => 'Jueves',
            'V' => 'Viernes',
            'S' => 'Sábado',
            'D' => 'Domingo'
        ];

        $html = "<div class='lab-schedule'>";
        foreach ($schedule as $day => $slots) {
            $dayName = isset($dayNames[$day]) ? $dayNames[$day] : $day;
            $html .= "<div class='day'><h3>{$dayName}</h3><ul>";

            foreach ($slots as $slot) {
                $html .= "<li><strong>From:</strong> {$slot['start_date']} <strong>To:</strong> {$slot['end_date']}</li>";
            }

            $html .= "</ul></div>";
        }
        $html .= "</div>";

        return $html;
    }
}
