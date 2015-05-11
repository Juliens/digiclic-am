<?php

namespace Digiclic\FrontArchiveMediaBundle\Providers;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientsProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $jsonUser = file_get_contents('http://clients/clients?email='.$username);
        $user = json_decode($jsonUser, true);
        if ($user!=null) {
            return new Client($user[0]['email'], $user[0]['password'], $user[0]['id']);
        }
        throw new \Exception('Wrong user');
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        //throw new \RuntimeException('Not implemented, yet.');
    }


}

