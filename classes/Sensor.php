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
}