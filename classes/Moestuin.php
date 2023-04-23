<?php 
class Moestuin{
    private string $name;
    private int $serre;
    private int $userId;
    private array $sensors;
    private array $plants;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of serre
     */ 
    public function getSerre()
    {
        return $this->serre;
    }

    /**
     * Set the value of serre
     *
     * @return  self
     */ 
    public function setSerre($serre)
    {
        $this->serre = $serre;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of sensors
     */ 
    public function getSensors()
    {
        return $this->sensors;
    }

    /**
     * Set the value of sensors
     *
     * @return  self
     */ 
    public function setSensors($sensors)
    {
        $this->sensors = $sensors;

        return $this;
    }

    /**
     * Get the value of plants
     */ 
    public function getPlants()
    {
        return $this->plants;
    }

    /**
     * Set the value of plants
     *
     * @return  self
     */ 
    public function setPlants($plants)
    {
        $this->plants = $plants;

        return $this;
    }
    
    public function save(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into moestuin (name, is_serre, user_id) values (:name, :serre, :user_id)");
        $statement->bindValue(":name", $this->getName());
        $statement->bindValue(":serre", $this->getSerre());
        $statement->bindValue(":user_id", $this->getUserId());
        $statement->execute();
        $moestuinId = $conn->lastInsertId();
        foreach($this->getSensors() as $sensor){
            //get the name of the sensor
            $statement = $conn->prepare("select id from sensors where name = :name");
            $statement->bindValue(":name", $sensor);
            $statement->execute();
            $sensorID = $statement->fetch();
            $sensorID = $sensorID["id"];
            $statement = $conn->prepare("insert into moestuin_sensor (moestuin_id, sensor_id) values (:moestuin_id, :sensor_id)");
            $statement->bindValue(":moestuin_id", $moestuinId);
            $statement->bindValue(":sensor_id", $sensorID);
            $statement->execute();
        }
        foreach($this->getPlants() as $plant){
            //get the name of the plant
            $statement = $conn->prepare("select id from planten where name = :name");
            $statement->bindValue(":name", $plant);
            $statement->execute();
            $plant = $statement->fetch();
            $plant = $plant["id"];
            $statement = $conn->prepare("insert into plant_moestuin (moestuin_id, plant_id) values (:moestuin_id, :plant_id)");
            $statement->bindValue(":moestuin_id", $moestuinId);
            $statement->bindValue(":plant_id", $plant);
            $statement->execute();
        }
    }
}
?>