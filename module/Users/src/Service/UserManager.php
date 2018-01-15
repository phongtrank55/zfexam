<?php
namespace Users\Service;

use Users\Entity\User;
use Zend\Crypt\Password\Apache;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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

    public function createTokenPasswordReset($user){
        $token = \Zend\Math\Rand::getString(32, "1234567890ghjklqwertyuiopzxcvbnm", true);
        $user->setPwResetToken($token);
        $user->setPwResetTokenDate(new \DateTime());

        $this->entityManager->flush();


        //tạo tin nhắn
        $message = new Message();

        $http = isset($_SERVER['HTTPS']) ? "https://" :"http://";
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $url = $http.$host."/zfexam/public/user/setPassword/".$token;

        $bodyMessage = "Chào bạn ".$user->getFullname()."\nBạn vui lòng chọn link bên dưới để thực hiện reset mật khẩu:\n
                        $url\nNếu bạn không yêu cầu reset, xin vui lòng bỏ qua thông báo này";
        $message->addFrom("daugaudatinh@gmail.com")
                ->addTo($user->getEmail())
                ->setSubject('Reset Password')
                ->setBody($bodyMessage);

        //Gửi
        
        $transport = new SmtpTransport();
        $options   = new SmtpOptions([
            'name'              => 'smtp.gmail.com',
            'host'              => 'smtp.gmail.com',
            'port'              => 587,
            'connection_class'  => 'login',
            'connection_config' => [
                'username' => 'daugaudatinh@gmail.com',
                'password' => 'Thanhpro',
                'port'     => 587,
                'ssl'      => 'tls'
            ],
        ]);
        $transport->setOptions($options);
        $transport->send($message);
        

    }
}
?>