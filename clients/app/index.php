<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Clients\Client;
use Clients\Category;

require_once __DIR__.'/vendor/autoload.php'; 

$app = new Silex\Application(); 

$app['mongo.clients'] = $app->share(function () {
    $m = new MongoClient( "mongodb://db:27017"); // connect
    return $m->clients_db->clients;
});

$app['mongo.categories'] = $app->share(function () {
    $m = new MongoClient( "mongodb://db:27017"); // connect
    return $m->clients_db->categories;
});

$app['repository'] = $app->share(function ($app) {
    return new Clients\MongoClientsRepository($app['mongo.clients']);
});

$app['repository.categories'] = $app->share(function ($app) {
    return new Clients\MongoCategoriesRepository($app['mongo.categories']);
});


$app->get('/clients', function() use($app) { 
    $email = $app['request']->get('email');
    if ($email!=null) {
        return new JsonResponse($app['repository']->findByEmail($email));
    }
    return new JsonResponse($app['repository']->findAll());
}); 

$app->get('/clients/{id}', function($id) use($app) { 
    try {
        return new JsonResponse($app['repository']->get($id));
    } catch (Exception $e) {
        return new JsonResponse(null, 404);
    }
}); 

$app->post('/clients', function () use($app) {
    $data = json_decode($app['request']->getContent(), true);
    $data['password'] = sha1($data['password']);
    $client = $app['repository']->fetchToClient($data);
    $client = $app['repository']->insert($client);
    return new JsonResponse($client, 201);
});

$app->put('/clients/{id}', function ($id) use ($app) {
    $data = json_decode($app['request']->getContent(), true);
    $data = array_intersect_key($data, array_flip(array('nom', 'adresse')));
    if (count($data)==0) {
        return new JsonResponse(null, 500);
    }
    $app['mongo']->insert($data);
    return new JsonResponse($data, 201);
});


$app->get('/clients/{id}/categories', function($id) use($app) { 
    try {
        return new JsonResponse($app['repository.categories']->findForClient($id));
    } catch (Exception $e) {
        return new JsonResponse(null, 404);
    }
}); 

$app->get('/clients/{id}/categories/{category_id}', function($id, $category_id) use($app) { 
    try {
        return new JsonResponse($app['repository.categories']->get($category_id));
    } catch (Exception $e) {
        return new JsonResponse(null, 404);
    }
}); 

$app->post('/clients/{id}/categories', function ($id) use ($app) {
    $data = json_decode($app['request']->getContent(), true);
    $data['client_id'] = $id;
    $category = $app['repository.categories']->fetchToCategory($data);
    $category = $app['repository.categories']->insert($category);
    return new JsonResponse($category, 201);
});

require __DIR__.'/videos.php';

$app->run(); 
