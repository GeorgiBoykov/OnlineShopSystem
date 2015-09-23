<?php

namespace OnlineShop\models\Repositories;


use MVCFramework\DbAdapter;
use OnlineShop\models\BindingModels\CategoryBindingModel;
use OnlineShop\Models\Category;

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
        // and return it as a CategoryViewModel object
        $data = $this->db->getEntityById('categories', $id);
        if($data == null){
            return null;
        }

        $category = new Category($data['id'], $data['name'], $data['isDeleted'], $data['description']);

        return $category;
    }

    public function findByName($name){
        // Find a record with the name = $name
        // from the 'categories' table
        // and return it as a Category object
        $data = $this->db->getEntity('categories', array('name'=> $name));
        if($data == null){
            return null;
        }

        $category = new Category(
            $data['id'],
            $data['name'],
            $data['isDeleted'],
            $data['description']
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
                                        $categoryData['isDeleted'],
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
            'isDeleted' => 0,
        ));
    }

    public function changeName($name, $newName)
    {
        $this->db->updateEntity('categories', array('name' => $newName), array('name' => $name));
    }

    public function changeDescription($name, $newDescription)
    {
        $this->db->updateEntity('categories', array('description' => $newDescription), array('name' => $name));
    }

    public function remove($name)
    {
        $this->db->deleteEntity('categories', array('name' => $name));
    }
}