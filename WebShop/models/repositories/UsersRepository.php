<?php

namespace WebShop\models\repositories;

use MVCFramework\DbAdapter;
use WebShop\models\binding_models\UserBindingModel;
use WebShop\models\User;

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
        // and return it as a User object
        $data = $this->db->getEntityById('users', $id);
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

    public function findByUsername($username){
        // Find a record with the username = $username
        // from the 'users' table
        // and return it as a User object
        $data = $this->db->getEntitiesByCriteria('users', array('username'=> $username));
        $userData = $data[0];
        if($userData == null){
            return null;
        }

        $user = new User(
                        $userData['id'],
                        $userData['username'],
                        $userData['password'],
                        $userData['email'],
                        $userData['role_id'],
                        $userData['cash']
                    );
        return $user;
    }

    public function getUserProperty($id, $property){
        $property = $this->db->getEntityPropertyById('users', $id, $property);

        if(is_null($property)){
            throw new \Exception('No such property');
        }

        return $property;
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
            'role_id' => $user->getRoleId()
        ));
    }

    public function deductCashForPurchasedProducts($userId){
        $sql = "UPDATE users u
                JOIN users_products up ON u.id = up.user_id
                JOIN products p ON up.product_id = p.id
                SET cash = u.cash -
                    (SELECT SUM(p.price) FROM products p WHERE p.id
                    IN (SELECT product_id FROM users_products up WHERE up.user_id = u.id))
                WHERE u.id = ?";

        $this->db->query($sql, array($userId));
    }

    public function changePassword($username, $newPassword)
    {
        $this->db->updateEntityProperty('users',array('password' => $newPassword), array('username' => $username));
    }

    public function changeEmail($username, $newEmail)
    {
        $this->db->updateEntityProperty('users', array('email' => $newEmail), array('username' => $username));
    }

    public function remove($username)
    {
        $this->db->deleteEntity('users', array('username' => $username));
    }
}