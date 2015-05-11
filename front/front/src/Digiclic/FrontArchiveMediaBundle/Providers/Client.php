<?php

namespace Digiclic\FrontArchiveMediaBundle\Providers;

use Symfony\Component\Security\Core\User\UserInterface;

class Client implements UserInterface
{

    private $email;
    private $password;
    private $id;

    public function __construct($email, $password, $id)
    {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return array();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return "";
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

}

