<?php

namespace WebShop\models\repositories;


use MVCFramework\DbAdapter;
use WebShop\models\binding_models\CategoryBindingModel;
use WebShop\models\Category;

class CategoriesRepository
{
    protected $db;

    public function __construct(DbAdapter $db)
    {
        $this->db = $db;
    }


    public function find($id)
    {
        // Find a record with the id = $id
        // from the 'categories' table
        // and return it as a Category object
        $data = $this->db->getEntityById('categories', $id);
        if($data == null){
            return null;
        }

        $category = new Category($data['id'], $data['name'], $data['is_deleted'], $data['description']);

        return $category;
    }

    public function findByName($name){
        // Find a record with the name = $name
        // from the 'categories' table
        // and return it as a Category object
        $data = $this->db->getEntitiesByCriteria('categories', array('name'=> $name));
        $categoryData = $data[0];
        if($categoryData == null){
            return null;
        }

        $category = new Category(
            $categoryData['id'],
            $categoryData['name'],
            $categoryData['is_deleted'],
            $categoryData['description']
        );

        return $category;
    }

    public function getAll(){
        $categories = array();
        $categoriesData = $this->db->getAllEntities('categories');

        foreach($categoriesData as $categoryData){
            $category = new Category(
                                        $categoryData['id'],
                                        $categoryData['name'],
                                        $categoryData['is_deleted'],
                                        $categoryData['description']
                                    );
            array_push($categories, $category);
        }

        return $categories;
    }

    public function getAllNotDeleted(){
        $categories = array();
        $categoriesData = $this->db->query('SELECT * FROM categories WHERE is_deleted = 0');

        foreach($categoriesData as $categoryData){
            $category = new Category(
                                        $categoryData['id'],
                                        $categoryData['name'],
                                        $categoryData['is_deleted'],
                                        $categoryData['description']
                                    );
            array_push($categories, $category);
        }

        return $categories;
    }

    public function create(CategoryBindingModel $category)
    {
        // Insert or update the $category
        // in the 'categories' table
        $this->db->insertEntity('categories', array(
                                                    'name' => $category->getName(),
                                                    'description' => $category->getDescription(),
                                                    'is_deleted' => false,
                                                    ));
    }

    public function updateCategory($updateData, $whereProductKeyValue)
    {
        $this->db->updateEntity('categories', $updateData, $whereProductKeyValue);
    }

    public function changeName($name, $newName)
    {
        $this->db->updateEntityProperty('categories', array('name' => $newName), array('name' => $name));
    }

    public function changeDescription($name, $newDescription)
    {
        $this->db->updateEntityProperty('categories', array('description' => $newDescription), array('name' => $name));
    }

    public function remove($name)
    {
        $this->db->updateEntityProperty('categories',array('is_deleted' => true), array('name' => $name));
    }
}