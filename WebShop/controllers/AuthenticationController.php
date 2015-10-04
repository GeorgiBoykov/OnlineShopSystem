<?php

namespace WebShop\controllers;


use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use WebShop\models\binding_models\LoginBindingModel;
use WebShop\models\binding_models\UserBindingModel;
use WebShop\models\repositories\UsersRepository;
use WebShop\models\view_models\AuthenticationViewModel;

class AuthenticationController extends BaseController
{
    private $_usersRepo = null;

    public function __construct(){
        parent::__construct();
        $this->_usersRepo = new UsersRepository(DbAdapter::getInstance());
    }

    public function onInit(){
    }

    public function index(){
        $view = new AuthenticationViewModel();
        $view->render();
    }

    /**
     * @param UserBindingModel $user
     * @throws \Exception
     * @Route("register")
     */
    public function registerUser(UserBindingModel $user){

        if($_POST['csrf'] !== $_SESSION["token"]){
            http_response_code(400);
            ob_end_clean();
            echo "CSRF not matching error";
            die;
        }

        if(!$user->modelState()->isValid()){
            http_response_code(400);
            ob_end_clean();
            var_dump($user->modelState()->get());
            die;
            //throw new \Exception('Model state not valid');
        }
        $userExists = $this->_usersRepo->findByUsername($user->getUsername());

        if(!is_null($userExists)){
            http_response_code(400);
            ob_end_clean();
            $username = $userExists->getUsername();
            echo "Username $username already taken";
            die;
        }

        $this->_usersRepo->create($user);
        $newUser = $this->_usersRepo->findByUsername($user->getUsername());

        $_SESSION['is_logged'] = true;
        $_SESSION['user_id'] = $newUser->getId();
        $_SESSION['username'] = $newUser->getUsername();
        $_SESSION['role_id'] = $newUser->getRoleId();
    }

    /**
     * @param LoginBindingModel $loginData
     * @throws \Exception
     * @Route("login")
     */
    public function loginUser(LoginBindingModel $loginData){
        $username = $loginData->getUsername();
        $password = $loginData->getPassword();

        if($_POST['csrf'] !== $_SESSION["token"]){
            http_response_code(400);
            ob_end_clean();
            echo "CSRF not matching error";
            die;
        }

        if(!$loginData->modelState()->isValid()){
            http_response_code(400);
            ob_end_clean();
            var_dump($loginData->modelState()->get());
            die;
        }

        $user = $this->_usersRepo->findByUsername($username);

        if(is_null($user)){
            http_response_code(400);
            ob_end_clean();
            echo "No such user found.";
            die;
        }

        if($user->getPassword() != $password){
            http_response_code(400);
            ob_end_clean();
            echo "Password doesn`t match.";
            die;
        }

        $_SESSION['is_logged'] = true;
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role_id'] = $user->getRoleId();
    }

    public function logout(){
        session_unset();
        session_destroy();
    }
}