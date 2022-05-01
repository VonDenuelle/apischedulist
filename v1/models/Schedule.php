<?php
class Schedule
{
    // DB
    private $conn;

    // post properties
    public $id;
    public $userid;
    public $day;
    public $time;
    public $title;
    public $description;
    public $vibrate;
    public $toggle;


    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     *  =========== POST METHODS ==========
     */
    public function AddSchedule()
    {
        $query = 'INSERT INTO schedule(
        userid, 
        day, 
        time, 
        title, 
        description, 
        vibrate,
        toggle
        ) Values(
            :userid,
            :day,
            :time,
            :title,
            :description,
            :vibrate,
            :toggle 
            )';

        $stmt = $this->conn->prepare($query);

        $this->userid = htmlspecialchars($this->userid);
        $this->day = htmlspecialchars($this->day);
        $this->time = htmlspecialchars($this->time);
        $this->title = htmlspecialchars($this->title);
        $this->description = htmlspecialchars($this->description);
        $this->vibrate = htmlspecialchars($this->vibrate);
        $this->toggle = htmlspecialchars($this->toggle);


        $sched = array(
            'userid' => $this->userid,
            'day' => $this->day,
            'time' => $this->time,
            'title' => $this->title,
            'description' => $this->description,
            'vibrate' => $this->vibrate,
            'toggle' => $this->toggle
        );

        if ($stmt->execute($sched)) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function checkDayAndTimeConflicts()
    {
        $query = "SELECT day, time FROM schedule WHERE 
                userid = :userid 
            AND 
                day = :day
            AND 
                time = :time";
        $stmt = $this->conn->prepare($query);

        $this->userid = htmlspecialchars($this->userid);
        $this->day = htmlspecialchars($this->day);
        $this->time = htmlspecialchars($this->time);

        $sched = array(
            'userid' => $this->userid,
            'day' => $this->day,
            'time' =>  $this->time
        );

        if ($stmt->execute($sched)) {
            $rowCount = $stmt->rowCount();
            return  $rowCount;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }


    public function todaySchedules()
    {
        $query = "SELECT * FROM schedule WHERE userid = :userid AND day = :day ORDER BY time ASC";
        $stmt = $this->conn->prepare($query);

        $this->userid = htmlspecialchars($this->userid);
        $this->day = htmlspecialchars($this->day);

        $sched = array(
            'userid' => $this->userid,
            'day' => $this->day
        );

        if ($stmt->execute($sched)) {
            $row = $stmt->fetchAll();
            return  $row;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function allSchedules()
    {
        $query = "SELECT * FROM schedule WHERE userid = :userid  ORDER BY time ASC";
        $stmt = $this->conn->prepare($query);

        $this->userid = htmlspecialchars($this->userid);

        if ($stmt->execute(['userid' => $this->userid])) {
            $row = $stmt->fetchAll();
            return  $row;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }


    /**
     *  =========== PATHC METHODS ==========
     */
    public function updateSchedule()
    {
        $query = 'UPDATE schedule SET 
            time = :time,
            title = :title,
            description = :description,
            vibrate = :vibrate,
            toggle = :toggle

        WHERE
            id = :id';

        $stmt = $this->conn->prepare($query);

        $this->time = htmlspecialchars($this->time);
        $this->title = htmlspecialchars($this->title);
        $this->description = htmlspecialchars($this->description);
        $this->vibrate = htmlspecialchars($this->vibrate);
        $this->toggle = htmlspecialchars($this->toggle);
        $this->id = htmlspecialchars($this->id);

        $sched = array(
            'time' => $this->time,
            'title' => $this->title,
            'description' => $this->description,
            'vibrate' => $this->vibrate,
            'toggle' => $this->toggle,
            'id' => $this->id
        );

       
        if ( $stmt->execute($sched)) {
            return  true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }


    public function updateToggle()
    {
        $query = 'UPDATE schedule SET 
            toggle = :toggle
        WHERE
            id = :id';

    $stmt = $this->conn->prepare($query);

    $this->toggle = htmlspecialchars($this->toggle);
    $this->id = htmlspecialchars($this->id);

    $sched = array(
        'toggle' => $this->toggle,
        'id' => $this->id
    );

   
    if ( $stmt->execute($sched)) {
        return  true;
    } else {
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}


    /**
     *  ============== GET METHODS
     */
    public function scheduleById()
    {
        $query = "SELECT * FROM schedule WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars($this->id);


        if ($stmt->execute(['id' => $this->id])) {
            $row = $stmt->fetch();
            return  $row;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }


    /**
     *  ============== DELETE METHODS
     */
    public function deleteSchedule()
    {
        $query = "DELETE FROM schedule WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars($this->id);


        if ($stmt->execute(['id' => $this->id])) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
