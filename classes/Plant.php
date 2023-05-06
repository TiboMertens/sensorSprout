<?php

use SendGrid\Stats\Stats;

class Plant {
    public static function getAll($searchTerm){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from planten WHERE name LIKE :searchTerm");
        $statement->bindValue(":searchTerm", '%' . $searchTerm. '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getCurrentPlant($plant_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from planten where id = :plant_id");
        $statement->bindValue(":plant_id", $plant_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}