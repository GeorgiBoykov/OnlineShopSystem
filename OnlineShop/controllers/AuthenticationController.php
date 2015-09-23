<?php

namespace OnlineShop\controllers;


use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use OnlineShop\models\BindingModels\LoginBindingModel;
use OnlineShop\models\BindingModels\UserBindingModel;
use OnlineShop\models\Repositories\UsersRepository;
use OnlineShop\models\ViewModels\AuthenticationViewModel;

class AuthenticationController extends BaseController
{
    private $_repo = null;
    private $DEFAULT_USER_CASH = 100.00;
    private $DEFAULT_USER_ROLE = 1;

    public function __construct(){
        parent::__construct();
        $this->_repo = new UsersRepository(new DbAdapter());
    }

    public function onInit(){
    }

    public function index(){
        $view = new AuthenticationViewModel();
        $view->render();
    }

    /**
     * @param UserBindingModel $user
     * @Route("register")
     */
    public function registerUser(UserBindingModel $user){
        $user->setRole($this->DEFAULT_USER_ROLE);
        $user->setCash($this->DEFAULT_USER_CASH);
        $this->_repo->create($user);
        $newUser = $this->_repo->findByUsername($user->getUsername());
        $_SESSION['user_id'] = $newUser->getId();
        $this->redirect('home');
    }

    /**
     * @param LoginBindingModel $loginData
     * @throws \Exception
     * @Route("login")
     */
    public function loginUser(LoginBindingModel $loginData){
        $username = $loginData->getUsername();
        $password = $loginData->getPassword();

        $user = $this->_repo->findByUsername($username);

        if($user->getPassword() != $password){
            throw new \Exception('Wrong Password');
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $this->redirect('home');
    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('authentication');
    }
}