<?php
class User
{
    private int $id;
    private string $language;
    private string $username;
    private string $email;
    private string $password;
    private string $resetToken;
    private int $sensor;

    /**
     * Get the value of language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the value of language
     *
     * @return  self
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        //validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;

            return $this;
        } else {
            throw new Exception("Sorry, dit is geen geldig emailadres.");
        }
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        //hash password with a factor of 12
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId($username)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function canLogin($username, $password)
    {
        try {
            $conn = Db::getInstance();
        } catch (Throwable $e) {
            throw new Exception("connection failed.");
        }
        $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        //check if user exists, if not throw exception
        if (!$user) {
            throw new Exception("Incorrect username.");
        }

        $hash = $user['password'];

        //check if password is correct, if not throw exception
        if (password_verify($password, $hash)) {
            if (!empty($this->sensor)) {
                $this->linkSensorToUser($user['id']);
            }
            return true;
        } else {
            throw new Exception("Incorrect password.");
        }
    }

    public function checkEmail($email)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //if result is 1, email is already in use, else email is not in use
        if ($result) {
            return true;
        } else {
            throw new Exception("Email is not in use.");
        }
    }

    /**
     * Get the value of resetToken
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * Set the value of resetToken
     *
     * @return  self
     */
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function saveResetToken()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET reset_token = :token, tstamp= :tstamp WHERE email = :email");
        $statement->bindValue(":token", $this->resetToken);
        $statement->bindValue(":tstamp", time());
        $statement->bindValue(":email", $this->email);
        $result = $statement->execute();
        return $result;
    }

    public function sendResetMail($key)
    {
        $token = $this->resetToken;


        // send an email to the user
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("r0892926@student.thomasmore.be", "SensorSprout");
        $email->setSubject("Herstel je wachtwoord");
        $email->addTo($this->email);
        $email->addContent("text/plain", "Hey! Hier is de link om je wachtwoord te herstellen: http://localhost/php/sensorsprout/resetPassword.php?token=$token");
        $email->addContent(
            "text/html",
            "Hey! Hier is de link om je wachtwoord te herstellen: <strong> http://localhost/php/sensorsprout/resetPassword.php?token=$token </strong>"
        );

        $sendgrid = new \SendGrid($key);

        try {
            $response = $sendgrid->send($email);
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
            return false;
        }

        exit();
    }

    public function checkResetToken()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
        $statement->bindValue(":token", $this->resetToken);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //if result is 1, token is valid, else token is not valid
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkTimestamp()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT tstamp FROM users WHERE reset_token = :token");
        $statement->bindValue(":token", $this->resetToken);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $result = $result['tstamp'];

        //if result is 1, token is valid, else token is not valid
        if (time() - $result < 86400) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePassword()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL, tstamp = NULL WHERE reset_token = :token");
        $statement->bindValue(":password", $this->password);
        $statement->bindValue(":token", $this->resetToken);
        $result = $statement->execute();
        return $result;
    }

    public function getSensors()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT sensors.*
        FROM sensors
        INNER JOIN sensor_user ON sensors.id = sensor_user.sensor_id
        WHERE sensor_user.user_id = :id;");
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function save()
    {
        //save the newly created user to the database and save the id of this user and the id of the sensor to the sensor_user table
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO users (username, email, password) values (:username, :email, :password)");
        $statement->bindValue(":username", $this->getUsername());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());
        $result = $statement->execute();
        $user_id = $conn->lastInsertId();
        if (!empty($this->sensor)) {
            $this->linkSensorToUser($user_id);
        }
        return $result;
    }

    public function linkSensorToUser($user_id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO sensor_user (user_id, sensor_id) VALUES (:user_id, :sensor_id)");
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":sensor_id", $this->sensor);
        $result = $statement->execute();
        return $result;
    }

    /**
     * Get the value of sensor
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * Set the value of sensor
     *
     * @return  self
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;

        return $this;
    }
}
