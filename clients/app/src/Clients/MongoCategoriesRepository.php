<?php

namespace Clients;

class MongoCategoriesRepository implements CategoriesRepository
{

    private $collection;
    public function __construct(\MongoCollection $collection)
    {
        $this->collection = $collection;
    }

    public function findForClient($id)
    {
        $toReturn = array();

        foreach ($this->collection->find(array('client_id'=>$id)) as $data) {
            $toReturn[] = $this->fetchToCategory($data);
        }
        return $toReturn;
    }

    public function get($id)
    {
        $elem = $this->collection->findOne(array('_id'=>new \MongoId($id)));
        if ($elem==null) {
            throw new \Exception('Not found');
        }
        return $this->fetchToCategory($elem);
    }

    public function findBySlugForClient($slug, $client_id)
    {
        $toReturn = array();

        $elems = $this->collection->find(array('client_id'=>$client_id, 'slug'=>$slug));
        foreach ($elems as $data) {
            $toReturn[] = $this->fetchToCategory($data);
        }
        return $toReturn;
    }

    public function insert(Category $category)
    {
        $this->collection->insert($category);
        $category->id = (string)$category->_id;
        return $category;
    }

    public function fetchToCategory($data)
    {
        $category = new Category();
        if (isset($data['_id'])) {
            $category->id = (string)$data['_id'];
        }
        $category->nom = $data['nom'];
        $category->logo = $data['logo'];
        $category->slug = $data['slug'];
        $category->client_id = $data['client_id'];
        return $category;
    }

}

