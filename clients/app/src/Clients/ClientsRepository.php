<?php

namespace Clients;

interface ClientsRepository
{
    public function get($id);
    public function findAll();
    public function findByEmail($email);
    public function insert(Client $client);
    public function update(Client $client);
}

