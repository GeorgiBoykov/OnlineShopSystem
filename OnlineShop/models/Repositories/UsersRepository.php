<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 22-Sep-15
 * Time: 10:36 PM
 */

namespace OnlineShop\models\Repositories;


use MVCFramework\DbAdapter;
use OnlineShop\models\bindingModels\UserBindingModel;
use OnlineShop\models\User;
use OnlineShop\models\ViewModels\UserViewModel;

class UsersRepository
{
    protected $db;

    public function __construct(DbAdapter $db)
    {
        $this->db = $db;
    }


    public function find($id)
    {
        // Find a record with the id = $id
        // from the 'users' table
        // and return it as a UserViewModel object
        $data = $this->db->getEntityById('users', $id);
        if($data == null){
            return null;
        }

        $user = new UserViewModel(
                            $data['id'],
                            $data['username'],
                            $data['password'],
                            $data['email'],
                            $data['role_id'],
                            $data['cash']
                        );

        return $user;
    }

    public function findByUsername($username){
        // Find a record with the username = $username
        // from the 'users' table
        // and return it as a User object
        $data = $this->db->getEntity('users', array('username'=> $username));
        if($data == null){
            return null;
        }

        $user = new User(
                            $data['id'],
                            $data['username'],
                            $data['password'],
                            $data['email'],
                            $data['role_id'],
                            $data['cash']
                        );
        return $user;
    }

    public function create(UserBindingModel $user)
    {
        // Insert or update the $user
        // in the 'users' table
        $this->db->insertEntity('users', array(
            'username' => $user->getUsername(),
            'password'=> $user->getPassword(),
            'email' => $user->getEmail(),
            'cash' => $user->getCash(),
            'role_id' => $user->getRole()
        ));
    }

    public function changePassword($username, $newPassword)
    {
        $this->db->updateEntity('users',array('password' => $newPassword), array('username' => $username));
    }

    public function changeEmail($username, $newEmail)
    {
        $this->db->updateEntity('users', array('email' => $newEmail), array('username' => $username));
    }

    public function remove($username)
    {
        $this->db->deleteEntity('users', array('username' => $username));
    }
}