<?php

namespace Digiclic\FrontArchiveMediaBundle\Services;

class ClientsService
{
    private $base_path;
    private $client_id;

    public function __construct($base_path, $security_context)
    {
        $this->client_id = $security_context->getToken()->getUser()->getId();
        $this->base_path = $base_path;
    }

    public function getCategories()
    {
        return json_decode(file_get_contents($this->base_path.'/clients/'.$this->client_id.'/categories'), true);
    }

    public function getCategory($category)
    {
        return json_decode(file_get_contents($this->base_path.'/clients/'.$this->client_id.'/categories/'.$category), true);
    }

    public function getVideo($video)
    {
        $toReturn = json_decode(file_get_contents($this->base_path.'/clients/'.$this->client_id.'/videos/'.$video), true);
        return $toReturn;
    }

    public function getVideosForCategory($category)
    {
        return json_decode(file_get_contents($this->base_path.'/clients/'.$this->client_id.'/videos?categorie='.$category), true);
    }
}

