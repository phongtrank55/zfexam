<?php
namespace Users\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Users\Entity\User;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Apache;

class AuthAdapter implements AdapterInterface
{
    private $entityManager;
    private $username;
    private $password;

    public function  __construct($entityManager)
    {
        $this->entityManager = $entityManager;

    }

    public function setUsername($username){ $this->username = $username; }

    public function setPassword($password){ $this->password = $password; }

    public function authenticate()    
    {
        $user = $this->entityManager
                ->getRepository(User::class)
                // ->findOneBy(['username' => $this->username,
                //              'password' => $this->password]);
                ->findOneByUsername($username);
        
        if(!$user)
        {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ['Username không tôn tại']);
        }
        else
        {
            $apache = new Apache(['format' => 'md5']);
            if($apache->verify($this->password, $user->getPassword()))     
            {
                return new Result(Result::SUCCESS, $this->$username, ['Đăng nhập thành công']);
            }
            else
            {
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Sai mật khẩu']);
            }
        }

    }
}

?>