<?php

namespace Videos;

class VideosRepositoryFactory
{
    public function getRepositoryForClient($client_id)
    {
        $m = new \MongoClient( "mongodb://db:27017"); // connect
        $collection_name = 'videos_'.$client_id;
        $collection = $m->videos_db->$collection_name;
        return new MongoVideosRepository($collection);
    }
}

