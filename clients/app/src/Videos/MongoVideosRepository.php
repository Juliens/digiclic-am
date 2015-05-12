<?php

namespace Videos;

class MongoVideosRepository implements VideosRepository
{

    private $collection;
    private $slugify;
    public function __construct(\MongoCollection $collection, $slugify)
    {
        $this->slugify = $slugify;
        $this->collection = $collection;
    }

    public function findAll()
    {
        $toReturn = array();
        foreach ($this->collection->find() as $data) {
            $toReturn[] = $this->fetchToVideo($data);
        }
        return $toReturn;
    }

    public function findByCategorie($categorie_id)
    {
        $toReturn = array();
        foreach ($this->collection->find(array('categorie'=>$categorie_id)) as $data) {
            $toReturn[] = $this->fetchToVideo($data);
        }
        return $toReturn;
    }

    public function get($id)
    {
        $elem = $this->collection->findOne(array('_id'=>new \MongoId($id)));
        if ($elem==null) {
            throw new \Exception('Not found');
        }
        return $this->fetchToVideo($elem);
    }

    public function insert(Video $video)
    {
        $video->slug = $this->slugify->slugify($video->nom);
        $this->collection->insert($video);
        $video->id = (string)$video->_id;
        unset($video->_id);
        return $video;

    }

    public function findBySlug($slug)
    {
        $toReturn = array();

        $elems = $this->collection->find(array('slug'=>$slug));
        foreach ($elems as $data) {
            $toReturn[] = $this->fetchToVideo($data);
        }
        return $toReturn;
    }

    public function fetchToVideo($data)
    {
        if (is_array($data)) {
            $data = (object)$data;
        }
        $video = new Video();
        if (isset($data->_id)) {
            $video->id = (string)$data->_id;
        }
        $video->nom = isset($data->nom) ? $data->nom : null;
        $video->titre = isset($data->titre) ? $data->titre : null;
        $video->description = isset($data->description) ? $data->description : null;
        $video->identification = isset($data->identification) ? $data->identification : null;
        $video->realisation = isset($data->realisation) ? $data->realisation : null;
        $video->production = isset($data->production) ? $data->production : null;
        $video->type = isset($data->type) ? $data->type : null;
        $video->source = isset($data->source) ? $data->source : null;
        $video->duree = isset($data->duree) ? $data->duree : null;
        $video->categorie = isset($data->categorie) ? $data->categorie : null;
        $video->slug = isset($data->slug) ? $data->slug : null;
        return $video;
    }

}

