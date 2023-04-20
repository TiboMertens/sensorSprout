<?php
class User
{
    private int $id;
    private string $language;
    private string $username;
    private string $email;
    private string $password;


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

    public function save()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO users (language, username, email, password) values (:language, :username, :email, :password)");
        $statement->bindValue(":language", $this->getLanguage());
        $statement->bindValue(":username", $this->getUsername());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());
        $result = $statement->execute();
        return $result;
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
            return true;
        } else {
            throw new Exception("Incorrect password.");
        }
    }
}
