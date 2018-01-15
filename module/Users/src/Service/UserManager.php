<?php
namespace Users\Service;

use Users\Entity\User;
use Zend\Crypt\Password\Apache;

class UserManager
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function checkEmailExists($email, $id=null){
        if($email == '') return false; 
        if($id==null)
        {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($email);
            return $user !== null;
        }

        //khi sửa, kiểm tra email sửa có trùng vs các username khác hay k
        $sql = "SELECT u from Users\Entity\User u where u.email='$email' AND u.id != $id";
        $q = $this->entityManager->createQuery($sql);
        $result = $q->getResult();
        return !empty($result);
    }

    private function checkUsernameExists($username){
        $user = $this->entityManager->getRepository(User::class)->findOneByUsername($username);
        return $user !== null;
    }

    public function addUser($data){
        if($this->checkEmailExists($data['email']))
            throw new \Exception("Email ".$data['email']." đã có người sử dụng");
        if($this->checkUsernameExists($data['username']))
            throw new \Exception("Username ".$data['username']." đã có người sử dụng");

        $user = new User();
        $user->setUsername($data['username']);
        $user->setGender($data['gender']);
        $user->setAddress($data['address']);
        // echo \DateTime::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d');
        // echo date('Y-m-d', (\DateTime::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d'));
        // $user->setBirthdate(\DateTime::createFromFormat('d/m/Y', $data['birthdate']));
        $user->setBirthdate(new \DateTime($data['birthdate']));
        $user->setRole($data['role']);
        $user->setPassword((new Apache(['format' => 'md5']))->create($data['password']));
        $user->setPhone($data['phone']);
        $user->setFullname($data['fullname']);
        $user->setEmail($data['email']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function editUser($user, $data)
    {
        if($this->checkEmailExists($data['email'], $user->getId()))
            throw new \Exception("Email ".$data['email']." đã có người sử dụng");
        
            
        
        $user->setGender($data['gender']);
        $user->setAddress($data['address']);
        // echo \DateTime::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d');
        // echo date('Y-m-d', (\DateTime::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d'));
        // $user->setBirthdate(\DateTime::createFromFormat('d/m/Y', $data['birthdate']));
        $user->setBirthdate(new \DateTime($data['birthdate']));
        $user->setRole($data['role']);
        
        $user->setPhone($data['phone']);
        $user->setFullname($data['fullname']);
        $user->setEmail($data['email']);

        
        $this->entityManager->flush();
        return $user;
        
    }

    public function removeUser($user){
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    private function verifyPassword($securePass, $password)
    {
        $apache = new Apache(['format' => 'md5']);
        return $apache->verify($password, $securePass);
    }

    public function changePassword($user, $data)
    {
        if($data['old_pw']==$data['new_pw'])
            throw new \Exception("Mật khẩu cũ giống mật khẩu mới");

        $securePass = $user->getPassword();
        $password = $data['old_pw'];

        if($this->verifyPassword($securePass, $password))
            throw new \Exception("Mật khẩu cữ không đúng!");

        $user->setPassword((new Apache(['format' => 'md5']))->create($data['new_pw']));
        $this->entityManager->flush();
    }
}
?>