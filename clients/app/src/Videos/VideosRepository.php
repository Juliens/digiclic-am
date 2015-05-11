<?php

namespace Videos;

interface VideosRepository
{
    public function findAll();
    public function get($id);
    public function insert(Video $video);
    public function fetchToVideo($data);
}

