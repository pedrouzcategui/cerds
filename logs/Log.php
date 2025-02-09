<?php

require_once "c:/xampp/htdocs/sistema-cursos/db.php";

class Log
{
    private $id;
    private $user_id;
    private $action;
    private $created_at;
    private static $table = "logs";

    // Constructor
    function __construct($id, $user_id, $action, $created_at)
    {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setAction($action);
        $this->setCreatedAt($created_at);
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public static function create($user_id, $action)
    {
        DB::query("INSERT INTO " . self::$table . " (user_id, action) VALUES (?, ?)", [$user_id, $action]);
    }

    public static function getAll($order = 'DESC')
    {
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $result = DB::query("SELECT * FROM " . self::$table . " ORDER BY id $order");
        $logs = [];
        foreach ($result as $log) {
            $logs[] = new self(
                $log['id'],
                $log['user_id'],
                $log['action'],
                $log['created_at']
            );
        }
        return $logs;
    }
}
