<?php 
class Sensor {
    public static function getSensorByQrCode($qr_code){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from sensors where qr_code = :qr_code");
        $statement->bindValue(":qr_code", $qr_code);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllSensors(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from sensors");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllPackets(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from packets");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getPacketDetails(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from packets where id = :id");
        $statement->bindValue(":id", $_GET['id']);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getSensorDetailsFromPacket(){
        $conn = Db::getInstance();
        //get all sensors from current packet, there is a table packets, sensors and packet_sensor
        $statement = $conn->prepare("select * from sensors inner join packet_sensor on sensors.id = packet_sensor.sensor_id where packet_id = :id");
        $statement->bindValue(":id", $_GET['id']);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getSensorId($sensor_name){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select id from sensors where name = :name");
        $statement->bindValue(":name", $sensor_name);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}