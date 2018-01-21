<?php
namespace Users\Service;

class AuthManager
{
    private $authenticationService;
    private $sessionManager;
    private $config;
    
    public function __construct($authenticationService, $sessionManager, $config)
    {
        $this->authenticationService = $authenticationService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }

    public function login($username, $password, $rememberMe)
    {
        if($this->authenticationService->hasIdentity())
            throw new \Exception("Ban da dang nhap!");
        
        $authAdapter = $this->authenticationService->getAdapter();
        $authAdapter->setUsername($username);
        $authAdapter->setPassword($password);

        $result = $this->authenticationService->authenticate();
        if($result->getCode() == \Zend\Authentication\Result::SUCCESS && $rememberMe)
            $this->sessionManager->rememberMe(86400);
        
        return $result;
    }

    public function logout()
    {
        if($this->authenticationService->hasIdentity())
        {
            $this->authenticationService->clearIdentity();
        }   
    }

    public function filterAccess($controllerName, $actionName)
    {
        if(isset($this->config['controllers'][$controllerName]))
        {
            $controllers = $this->config['controllers'][$controllerName];
            foreach($controllers as $controller)
            {
                $listAction = $controller['actions'];
                $allow = $controller['allow'];
                if(in_array($actionName, $listAction))
                {
                    //Neu action dc cho phep hoac da dang nhap thi dc vao
                    if($allow == '*' || $allow == '@' && $this->authenticationService->hasIdentity())
                        return true;
                    return false;
                    
                }
            }
            
        }
        return true;
    }
}

?>