<?php

namespace Clients;

class MongoClientsRepository implements ClientsRepository
{
    private $collection;
    public function __construct(\MongoCollection $collection)
    {
        $this->collection = $collection;
    }

    public function get($id)
    {
        $elem = $this->collection->findOne(array('_id'=>new \MongoId($id)));
        if ($elem==null) {
            throw new \Exception('Not found');
        }
        return $elem;
    }

    public function findByEmail($email)
    {
        $toReturn = array();
        foreach ($this->collection->find(array('email'=>$email)) as $data) {
            $toReturn[] = $this->fetchToClient($data);
        }
        return $toReturn;
    }

    public function findAll()
    {
        $toReturn = array();
        foreach ($this->collection->find() as $data) {
            $toReturn[] = $this->fetchToClient($data);
        }
        return $toReturn;
    }

    public function insert(Client $client)
    {
        $this->collection->insert($client);
        $client->id = (string)$client->_id;
        unset($client->_id);
        return $client;

    }

    public function update(Client $client)
    {
        $elem = $this->get($id);
        $this->collection->save($client);
    }

    public function fetchToClient($elem)
    {
        $client = new Client();
        $client->id = (string)$elem['_id'];
        $client->nom = $elem['nom'];
        $client->adresse = $elem['adresse'];
        $client->email = $elem['email'];
        $client->password = $elem['password'];
        return $client;
    }

}

