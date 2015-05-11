<?php

namespace Clients;

interface CategoriesRepository
{
    public function findForClient($id);
}

