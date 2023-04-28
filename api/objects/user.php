<?php
abstract class User
{
    public $id;
    public $username;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $gender;
    public $phoneNumber;
    public $age;

    // getters and setters
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        if (strlen($username) >= 3) {
            $this->username = $username;
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        if (strlen($firstName) >= 3) {
            $this->firstName = $firstName;
        }
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        if (strlen($lastName) >= 3) {
            $this->lastName = $lastName;
        }
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (strlen($password) >= 6) {
            $this->password = $password;
        }
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    // generate random password of length 8 characters and numbers and special characters
    public function generatePassword()
    {
        $password = "";
        $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-=+;:,.?";
        $maxlength = strlen($possible);
        if ($maxlength > 0) {
            for ($i = 0; $i < 8; $i++) {
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                $password .= $char;
            }
        }
        return $password;
    }

    // check if given email exists in the database
    abstract public function emailExists($email);

    // check if given username exists in the database
    // abstract public function usernameExists();

    // // create new user record
    abstract public function create($data);

    // // update user record
    // abstract public function update();

    // // delete user record
    // abstract public function delete();

    // // read all user records
    // abstract public function readAll();

    // // read one user by id
    abstract public function readOne($id);

    // // read one user by username
    // abstract public function readOneByUsername($username);
}
