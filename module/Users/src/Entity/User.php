<?php
namespace Users\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    //`id`, `username`, `password`, `fullname`, `birthdate`, `gender`,
    // `address`, `email`, `phone`, `role`, `pw_reset_token`, `pw_reset_token_date`
    //DEFAULT: TYPE= "STRING"
    /**
     * @Id 
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;
    /** @Column(type="string", length=20, name="username") */
    private $username;
    /** @Column(type="string", length=100) */
    private $password;
    /** @Column(type="string", length=100) */
    private $fullname;
    /** @Column(type="date") */
    private $birthdate;
    /** @Column() */
    private $gender;
     /** @Column() */
    private $address;
     /** @Column() */
    private $email;
     /** @Column() */
    private $phone;
     /** @Column() */
    private $role;
    /** @Column(name="pw_reset_token") */
    private $pwResetToken;
    /** @Column(type="datetime", name="pw_reset_token_date") */
    private $pwResetTokenDate;

    /** @return */
    public function getId() { return $this->id; }
    /** @param */
    public function setId($id) { $this->id = $id; }

    /** @return */
    public function getUsername() { return $this->username; }
    /** @param */
    public function setUsername($username) { $this->username = $username;}
    
    /** @return */
    public function getPassword() { return $this->password; }
    /** @param */
    public function setPassword($password) { $this->password = $password;}
    
    /** @return */
    public function getFullname() { return $this->fullname; }
    /** @param */
    public function setFullname($fullname) { $this->fullname = $fullname;}
    
    /** @return */
    public function getBirthdate() { return $this->birthdate; }
    /** @param */
    public function setBirthdate($birthdate) { $this->birthdate = $birthdate;}
    
    /** @return */
    public function getGender() { return $this->gender; } 
    /** @param */
    public function setGender($gender) {  $this->gender = $gender;}
    
    /** @return */
    public function getAddress() { return $this->address; }
    /** @param */
    public function setAddress($address) { $this->address = $address;}
    
    /** @return */
    public function getEmail() { return $this->email; }
    /** @param */
    public function setEmail($email) { $this->email = $email;}
    
    /** @return */
    public function getPhone() { return $this->phone; }
    /** @param */
    public function setPhone($phone) { $this->phone = $phone;}
    
    /** @return */
    public function getRole() { return $this->role; }
    /** @param */
    public function setRole($role) { $this->role = $role;}
    
    
    /** @return */
    public function getPwResetToken() { return $this->pwResetToken; }
    /** @param */
    public function setPwResetToken($pwResetToken) {$this->pwResetToken = $pwResetToken;}
    
    
    /** @return */
    public function getPwResetTokenDate() { return $this->pwResetTokenDate; }
    /** @param */
    public function setPwResetTokenDate($pwResetTokenDate) { $this->pwResetTokenDate = $pwResetTokenDate;}
    
}


?>