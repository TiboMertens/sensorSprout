<?php

use SendGrid\Stats\Stats;

class Plant {
    public static function getAll(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from planten");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}