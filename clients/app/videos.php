<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Videos\Video;

$app['repository_factory'] = $app->share(function ($app) {
    return new Videos\VideosRepositoryFactory();
});

$app->get('/clients/{client_id}/videos', function($client_id) use($app) { 
    $categorie = $app['request']->get('categorie');
    if ($categorie!=null) {
        return new JsonResponse($app['repository_factory']->getRepositoryForClient($client_id)->findByCategorie($categorie));
    }
    return new JsonResponse($app['repository_factory']->getRepositoryForClient($client_id)->findAll());
}); 

$app->get('/clients/{client_id}/videos/{id}', function($client_id,$id) use($app) { 
    try {
        return new JsonResponse($app['repository_factory']->getRepositoryForClient($client_id)->get($id));
    } catch (Exception $e) {
        return new JsonResponse(null, 404);
    }
}); 

$app->post('/clients/{client_id}/videos', function ($client_id) use($app) {
    $data = json_decode($app['request']->getContent());
    $video = $app['repository_factory']->getRepositoryForClient($client_id)->fetchToVideo($data);
    $video = $app['repository_factory']->getRepositoryForClient($client_id)->insert($video);
    return new JsonResponse($video, 201);
});

